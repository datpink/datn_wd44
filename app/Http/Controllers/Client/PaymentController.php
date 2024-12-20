<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Models\UserPoint;
use App\Models\UserPointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    public function vnpay(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            // dd($user);
            if($user->status === "locked"){
                Auth::logout();
                return redirect()->route('login')->withErrors(['username' => 'Tài khoản của bạn đã bị khóa.']);
            }
            // Lấy giá trị từ input
            $paymentMethodRaw = $request->payment_method;
            $paymentMethod = json_decode($paymentMethodRaw, true);
            $paymentMethodId = $paymentMethod['id'];
            $paymentMethodName = $paymentMethod['name'];
            // dd($request->products);
            // Kiểm tra tồn kho trước khi tạo đơn hàng
            foreach ($request->products as $product) {
                $productst = Product::where('id', $product['id'])->first();
                if($productst->is_active == 0){
                    return redirect()->route('cart.view')
                    ->with('error', "Sản phẩm {$productst->name} đã ngừng kinh doanh.");
                }
                if ($product['variant_id']) {
                    $productVariant = ProductVariant::where('id', $product['variant_id'])
                        ->lockForUpdate()
                        ->firstOrFail();
                    // dd($productVariant);
                    if($productVariant->status == "inactive"){
                        return redirect()->route('cart.view')
                        ->with('error', "Sản phẩm {$productVariant->variant_name} đã hết hàng hoặc không đủ số lượng. Vui lòng thử lại.");
                    }
                    if ($productVariant->stock < $product['quantity']) {
                        DB::rollBack();
                        return redirect()->route('cart.view')
                            ->with('error', "Sản phẩm {$productVariant->product->name} đã hết hàng hoặc không đủ số lượng. Vui lòng thử lại.");
                    }
                } else {
                    $productModel = Product::where('id', $product['id'])
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($productModel->stock < $product['quantity']) {
                        DB::rollBack();
                        return redirect()->route('cart.view')
                            ->with('error', "Sản phẩm {$productModel->name} đã hết hàng hoặc không đủ số lượng. Vui lòng thử lại.");
                    }
                }
            }

            // Chuẩn bị dữ liệu cho đơn hàng
            $pmst = $paymentMethodName === 'cod' ? 'unpaid' : 'pending';
            $data = [
                'user_id' => auth()->id(),
                'promotion_id' => $request->promotion_id,
                'total_amount' => $request->totalAmount,
                'discount_amount' => $request->input('discount_display', default: 0),
                'payment_status' => $pmst,
                'shipping_address' => $request->full_address,
                'description' => $request->description,
                'payment_method_id' => $paymentMethodId,
                'phone_number' => $request->phone_number,
            ];
            $points = $request->points;
            $order = Order::create($data);
            $sessionData = [
                'points'   => $points,
            ];

            // Lưu vào session với key là 'points'
            Session::put('points', $sessionData);

            $vnp_TxnRef = time();

            // Xử lý danh sách sản phẩm
            foreach ($request->products as $product) {
                $order->orderItems()->create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'product_variant_id' => $product['variant_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total' => $product['price'] * $product['quantity'],
                ]);
            }

            // Giảm tồn kho
            foreach ($request->products as $product) {
                if ($product['variant_id']) {
                    $productVariant = ProductVariant::findOrFail($product['variant_id']);
                    $productVariant->stock -= $product['quantity'];
                    $productVariant->save();
                    $productVariant->product->updateTotalStock();
                } else {
                    $productModel = Product::findOrFail($product['id']);
                    $productModel->stock -= $product['quantity'];
                    $productModel->save();
                }
            }
            if ($paymentMethodName === 'cod') {
                // if($request->totalAmount >100000){
                //     return back()->with('errors','Bạn cần thanh toán bằng ví điện tử cho đơn hàng trên 100 triệu');
                // }
                $userPoint = UserPoint::where('user_id', auth()->id())->first();
                $redeemPoint = $request->points;
                if ($redeemPoint > 0) {
                    UserPointTransaction::create([
                        'type' => 'redeem',
                        'user_point_id' => $userPoint->id,
                        'points' => $redeemPoint,
                        'description' => 'Thanh toán đơn hàng ' . $order->id,
                        'created_at' => now(),
                    ]);

                    $userPoint->update([
                        'total_points' => $userPoint->total_points - $redeemPoint,
                    ]);
                }
                // Xóa sản phẩm đã mua khỏi giỏ hàng
                $cartItems = session()->get('cart_'.auth()->id(), []);
                foreach ($request->products as $product) {
                    foreach ($cartItems as $key => $item) {
                        // Kiểm tra và xóa sản phẩm trong giỏ hàng dựa trên ID
                        if ($item['id'] == $product['id'] && $item['options']['variant_id'] == $product['variant_id']) {
                            unset($cartItems[$key]);
                        }
                    }
                }

                // Cập nhật lại giỏ hàng sau khi xóa các sản phẩm đã thanh toán
                session()->put('cart_'.auth()->id(), $cartItems);

                Mail::to($order->user->email)->send(new OrderConfirmation($order));
                DB::commit();
                return view('client.vnpay.cod-success', ['order' => $order]);
            }

            if ($paymentMethodName === 'vnpay') {
                $userToken = Crypt::encryptString(auth()->id());
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = route('vnpayReturn');
                $vnp_TmnCode = "6NK2ISZ9";
                $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF";
                $vnp_TxnRef = time();
                $vnp_OrderInfo = "Thanh toán hóa đơn";
                $vnp_OrderType = "ZAIA Enterprise";
                $vnp_Amount = (int) ($request->totalAmount * 100);
                $vnp_Locale = "VN";
                $vnp_BankCode = "NCB";
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                );

                ksort($inputData);
                $query = "";
                $hashdata = "";
                $i = 0;
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                Transaction::create([
                    'txn_ref' => $vnp_TxnRef,
                    'order_id' => $order->id,
                    'amount' => $request->totalAmount,
                    'order_info' => "Thanh toán đơn hàng #$vnp_TxnRef",
                    'status' => 'pending',
                ]);

                DB::commit();
                return redirect()->away($vnp_Url);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('order.failed')
                ->with('error', 'Có lỗi xảy ra 2: ' . $e->getMessage());
        }
    }

    public function vnpayReturn(Request $request)
    {
        // dd(session('points'));
        try {
            DB::beginTransaction();
            $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF";
            $inputData = $request->all();
            $vnp_SecureHash = $inputData['vnp_SecureHash'];
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);

            $hashData = '';
            foreach ($inputData as $key => $value) {
                $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
            }
            $hashData = rtrim($hashData, '&');
            $computedHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            if ($computedHash === $vnp_SecureHash) {
                $transaction = Transaction::where('txn_ref', $inputData['vnp_TxnRef'])->firstOrFail();
                $order = Order::findOrFail($transaction->order_id);

                if ($inputData['vnp_ResponseCode'] == '00') {
                    $transaction->status = 'paid';
                    $order->payment_status = 'paid';
                    $transaction->save();
                    $order->save();


                // Xóa sản phẩm đã mua khỏi giỏ hàng
                $cartItems = session()->get('cart_'.auth()->id(), []);
                foreach ($order->orderItems as $item) {
                    foreach ($cartItems as $key => $cartItem) {
                        if ($cartItem['id'] == $item->product_id && $cartItem['options']['variant_id'] == $item->product_variant_id) {
                            unset($cartItems[$key]); // Xóa sản phẩm khỏi giỏ hàng
                        }
                    }
                }
                // Cập nhật lại giỏ hàng trong session
                session()->put('cart_'.auth()->id(), $cartItems);


                    $ssData = Session::get('points');
                    $redeemPoint = $ssData['points'];
                    $userPoint = UserPoint::where('user_id', auth()->id())->first();
                    if ($redeemPoint > 0) {
                        UserPointTransaction::create([
                            'type' => 'redeem',
                            'user_point_id' => $userPoint->id,
                            'points' => $redeemPoint,
                            'description' => 'Thanh toán đơn hàng ' . $order->id,
                            'created_at' => now(),
                        ]);

                        $userPoint->update([
                            'total_points' => $userPoint->total_points - $redeemPoint
                        ]);
                    }
                    Session::forget('points');
                    Mail::to($order->user->email)->send(new OrderConfirmation($order));
                    DB::commit();
                    return view('client.vnpay.success', ['order' => $transaction]);
                } else {
                    foreach ($order->orderItems as $item) {
                        if ($item->product_variant_id) {
                            $productVariant = ProductVariant::findOrFail($item->product_variant_id);
                            $productVariant->stock += $item->quantity;
                            $productVariant->save();
                            $product = Product::findOrFail($item->product_id);
                            $product->updateTotalStock();
                        } else {
                            $product = Product::findOrFail($item->product_id);
                            $product->stock += $item->quantity;
                            $product->save();
                        }
                    }
                    $transaction->status = 'failed';
                    $order->payment_status = 'payment_failed';
                    $transaction->save();
                    $order->save();
                    DB::commit();
                    return view('client.vnpay.failed')->with('error', 'Thanh toán bị hủy');
                }
            } else {
                return view('client.vnpay.invalid');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.view')->with('error', 'hehe : ' . $e->getMessage());
        }
    }


    public function orderFailed()
    {
        return view('client.user.order-fail');
    }
}
