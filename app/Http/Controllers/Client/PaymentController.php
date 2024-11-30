<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

                DB::commit();
                // return redirect()->route('order.success', ['order_id' => $order->id])
                return redirect()->route('client.index')
                    ->with('success', 'Đặt hàng thành công. Thanh toán khi nhận hàng.');
            }
            if ($paymentMethodName === 'vnpay') {

                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return";
                $vnp_TmnCode = "6NK2ISZ9"; //Mã website tại VNPAY
                $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF"; //Chuỗi bí mật
                $vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
                $vnp_OrderInfo = "Thanh toán hóa đơn";
                $vnp_OrderType = "ZAIA Enterprise";
                $vnp_Amount  = (int)($request->totalAmount * 100); // Chuyển thành số nguyên (VND)
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
                if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
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

                Transaction::create([
                    'txn_ref' => $vnp_TxnRef,
                    'amount' => $request->totalAmount,
                    'order_info' => "Thanh toán đơn hàng #$vnp_TxnRef",
                    'status' => 'paid',
                    'vnp_response_code' => '00',
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

        dd($request->all());
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
            DB::beginTransaction(); // Bắt đầu transaction
            try {
                // Lấy đơn hàng từ txn_ref
                $order = Transaction::where('txn_ref', $inputData['vnp_TxnRef'])->firstOrFail();

                // Kiểm tra mã phản hồi từ VNPAY
                if ($inputData['vnp_ResponseCode'] == '00') {
                    $order->status = 'paid'; // Thanh toán thành công
                    $order->save();
                    DB::commit(); // Lưu thay đổi
                    return view('client.vnpay.success', ['order' => $order]);
                } else {
                    throw new \Exception("Giao dịch không thành công.");
                }
            } catch (\Exception $e) {
                DB::rollBack(); // Hoàn tác nếu có lỗi
                return view('client.vnpay.failed')->with('error', $e->getMessage());
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
