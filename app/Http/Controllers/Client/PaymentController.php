<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function vnpay(Request $request)
    {
        // dd($request->all()); // Kiểm tra dữ liệu gửi đến
        // Lấy giá trị từ input
        $paymentMethodRaw = $request->input('payment_method');

        // Giải mã JSON thành mảng
        $paymentMethod = json_decode($paymentMethodRaw, true);

        // Lấy id và name
        $paymentMethodId = $paymentMethod['id'];
        $paymentMethodName = $paymentMethod['name'];
        // dd($paymentMethodId,$paymentMethodName );

        try {
            DB::beginTransaction();

            // Chuẩn bị dữ liệu cho đơn hàng
            $data = [
                'user_id' => auth()->id(),
                'promotion_id' => $request->promotion_id,
                'total_amount' => $request->totalAmount,
                'discount_amount' => $request->input('discount_display', 0),
                'payment_status' => $paymentMethodName === 'cod' ? 'pending' : 'paid',
                'shipping_address' => $request->full_address,
                'description' => $request->description,
                'payment_method_id' => $paymentMethodId,
                'phone_number' => $request->phone_number,
            ];

            $order = Order::create($data);
            $vnp_TxnRef = time();

            // Kiểm tra danh sách sản phẩm
            if (isset($request->products) && is_array($request->products) && count($request->products) > 0) {
                foreach ($request->products as $product) {
                    // Lưu sản phẩm vào orderItems
                    $order->orderItems()->create([
                        'order_id' => $order->id,
                        'product_id' => $product['id'],
                        'product_variant_id' => $product['variant_id'],
                        'quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'total' => $product['price'] * $product['quantity'],
                    ]);
                }
            } else {
                throw new \Exception("Danh sách sản phẩm không hợp lệ hoặc không tồn tại.");
            }

            // Xử lý theo phương thức thanh toán
            if ($paymentMethodName === 'cod') {
                // Phương thức thanh toán khi nhận hàng (COD)
                $order->payment_status = 'pending';
                $order->save();
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
                Mail::to($order->user->email)->send(new OrderConfirmation($order));
                DB::commit();
                return view('client.vnpay.cod-success', ['order' => $order]);
            }

            if ($paymentMethodName === 'vnpay') {
                $userToken = Crypt::encryptString(auth()->id()); // Mã hóa ID người dùng
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return";
                // $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return?token={$userToken}";
                $vnp_TmnCode = "6NK2ISZ9"; // Mã website tại VNPAY
                $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF"; // Chuỗi bí mật
                $vnp_TxnRef = time(); // Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
                $vnp_OrderInfo = "Thanh toán hóa đơn";
                $vnp_OrderType = "ZAIA Enterprise";
                $vnp_Amount = (int) ($request->totalAmount * 100); // Chuyển thành số nguyên (VND)
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

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

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
                    $query .= urlencode($key) . "=" . urlencode($value) . '&'; // Tạo chuỗi query
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                // Ghi lại giao dịch vào bảng Transaction
                Transaction::create([
                    'txn_ref' => $vnp_TxnRef,
                    'order_id' => $order->id,
                    'amount' => $request->totalAmount,
                    'order_info' => "Thanh toán đơn hàng #$vnp_TxnRef",
                    'status' => 'pending', // Ghi lại trạng thái ban đầu là pending
                ]);

                DB::commit();

                return redirect()->away($vnp_Url);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('order.failed')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }



    public function vnpayReturn(Request $request)
    {
        // if ($request->has('token')) {
        //     try {
        //         $userId = Crypt::decryptString($request->token); // Giải mã token
        //         $user = \App\Models\User::find($userId);

        //         if ($user) {
        //             Auth::login($user); // Đăng nhập lại
        //         }
        //     } catch (\Exception $e) {
        //         return response()->json(['error' => 'Token không hợp lệ'], 400);
        //     }
        // }
        // dd($request->all());
        Log::info('VNPAY Callback Data:', $request->all());

        Log::info('user', [auth()->user()]);
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

            // Lấy đơn hàng từ txn_ref
            $order = Transaction::where('txn_ref', $inputData['vnp_TxnRef'])->firstOrFail();
            $order2 = Order::where('id', $order->order_id)->firstOrFail();
            // Kiểm tra mã phản hồi từ VNPAY
            if ($inputData['vnp_ResponseCode'] == '00') {
                $order->status = 'paid'; // Thanh toán thành công
                $order2->payment_status = "paid";
                $order->save();
                $order2->save();
                // Gửi email xác nhận đơn hàng
                Mail::to($order2->user->email)->send(new OrderConfirmation($order2));

                // // Giảm số lượng tồn kho
                // foreach ($order2->orderItems as $item) {
                //     if ($item->product_variant_id) {
                //         // Cập nhật tồn kho cho biến thể
                //         $productVariant = ProductVariant::findOrFail($item->product_variant_id);
                //         $productVariant->stock -= $item->quantity;
                //         $productVariant->save();
                //     } else {
                //         // Cập nhật tồn kho cho sản phẩm đơn
                //         $product = Product::findOrFail($item->product_id);
                //         $product->stock -= $item->quantity;
                //         $product->save();
                //     }
                // }
                // Giảm số lượng tồn kho
                foreach ($order2->orderItems as $item) {
                    if ($item->product_variant_id) {
                        // Cập nhật tồn kho cho biến thể
                        $productVariant = ProductVariant::findOrFail($item->product_variant_id);
                        $productVariant->stock -= $item->quantity;
                        $productVariant->save();

                        // Cập nhật tồn kho cho sản phẩm gốc
                        $product = $productVariant->product; // Giả sử có mối quan hệ giữa biến thể và sản phẩm
                        $product->stock -= $item->quantity; // Giảm tồn kho của sản phẩm gốc
                        $product->save();
                        $product->updateTotalStock();
                    } else {
                        // Cập nhật tồn kho cho sản phẩm đơn
                        $product = Product::findOrFail($item->product_id);
                        $product->stock -= $item->quantity;
                        $product->save();
                    }
                }
                return view('client.vnpay.success', ['order' => $order]);
            } else {
                $order->status = 'failed'; // Giao dịch thất bại
                $order2->payment_status = "failed";
                $order->save();
                $order2->save();
                return view('client.vnpay.failed')->with('error', 'Thanh toán bị hủy');
            }
        } else {
            return view('client.vnpay.invalid');
        }
    }

    public function orderFailed()
    {
        return view('client.user.order-fail');
    }
}
