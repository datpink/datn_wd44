<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    public function vnpay(Request $request)
    {
        // Kiểm tra phương thức thanh toán
        $paymentMethod = $request->input('payment_method'); // 'vnpay' or 'shipcode'

        try {

            DB::beginTransaction();
            $data = [
                'user_id' => auth()->id(),
                'promotion_id' => $request->promotion_id,
                'total_amount' => $request->totalAmount,
                'discount_amount' => $request->input('discount_amount', 0),
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid', // Ship COD là 'pending', VNPAY là 'paid'
                'shipping_address' => $request->shipping_address,
                'description' => $request->description,
                'payment_method_id' => $request->payment_method_id,
                'phone_number' => $request->phone_number,

            ];
dd($data);
            $order = Order::create($data);
            // order detail
            foreach ($request->products as $product) {
                $order->orderDetails()->create([
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }

            // Bước 3: Xử lý thanh toán
            if ($paymentMethod === 'shipcode') {
                // Với Shipcode, cập nhật trạng thái đơn hàng và hoàn tất
                $order->payment_status = 'cod'; // Thanh toán khi nhận hàng
                $order->save();

                DB::commit(); // Lưu toàn bộ thay đổi
                return redirect()->route('order.success', ['order_id' => $order->id]);
            } elseif ($paymentMethod === 'vnpay') {
                // Với VNPAY, tạo URL thanh toán
                $vnp_TmnCode = "6NK2ISZ9";
                $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF";
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = route('vnpay.return');

                $vnp_TxnRef = time(); // Mã đơn hàng
                $vnp_Amount = $request->totalAmount * 100; // Đổi sang đơn vị xu
                $inputData = [
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
                    "vnp_Locale" => "vn",
                    "vnp_OrderInfo" => "Thanh toán đơn hàng #$vnp_TxnRef",
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                ];

                ksort($inputData);
                $query = http_build_query($inputData);
                $hashData = urldecode($query);
                $vnpSecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
                $paymentUrl = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

                // Cập nhật mã giao dịch cho đơn hàng
                $order->txn_ref = $vnp_TxnRef;
                $order->save();

                DB::commit(); // Lưu toàn bộ thay đổi trước khi chuyển đến VNPAY
                return redirect()->to($paymentUrl); // Chuyển đến trang thanh toán
            } else {
                throw new \Exception("Phương thức thanh toán không hợp lệ.");
            }
        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác tất cả các thay đổi nếu có lỗi
            return redirect()->route('order.failed')->with('error', $e->getMessage());
        }
    }

    public function vnpayReturn(Request $request)
    {
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
                $order = Order::where('txn_ref', $inputData['vnp_TxnRef'])->firstOrFail();

                // Kiểm tra mã phản hồi từ VNPAY
                if ($inputData['vnp_ResponseCode'] == '00') {
                    $order->payment_status = 'paid'; // Thanh toán thành công
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

    // public function vnpay(Request $request)
    // {
    //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    //     $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return";

    //     $vnp_TmnCode = "6NK2ISZ9"; //Mã website tại VNPAY
    //     $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF"; //Chuỗi bí mật

    //     $vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
    //     $vnp_OrderInfo = "Thanh toán hóa đơn";
    //     $vnp_OrderType = "ZAIA Enterprise";
    //     $vnp_Amount = $request->totalAmount *100;
    //     $vnp_Locale = "VN";
    //     $vnp_BankCode = "NCB";
    //     $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //     $inputData = array(
    //         "vnp_Version" => "2.1.0",
    //         "vnp_TmnCode" => $vnp_TmnCode,
    //         "vnp_Amount" => $vnp_Amount,
    //         "vnp_Command" => "pay",
    //         "vnp_CreateDate" => date('YmdHis'),
    //         "vnp_CurrCode" => "VND",
    //         "vnp_IpAddr" => $vnp_IpAddr,
    //         "vnp_Locale" => $vnp_Locale,
    //         "vnp_OrderInfo" => $vnp_OrderInfo,
    //         "vnp_OrderType" => $vnp_OrderType,
    //         "vnp_ReturnUrl" => $vnp_Returnurl,
    //         "vnp_TxnRef" => $vnp_TxnRef,
    //     );

    //     if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    //         $inputData['vnp_BankCode'] = $vnp_BankCode;
    //     }
    //     if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    //         $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    //     }

    //     //var_dump($inputData);
    //     ksort($inputData);
    //     $query = "";
    //     $i = 0;
    //     $hashdata = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashdata .= urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //     }

    //     $vnp_Url = $vnp_Url . "?" . $query;
    //     if (isset($vnp_HashSecret)) {
    //         $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
    //         $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    //     }
    //     $returnData = array(
    //         'code' => '00',
    //         'message' => 'success',
    //         'data' => $vnp_Url
    //     );
    //     header('Location: ' . $vnp_Url);
    //     exit();

    //     // vui lòng tham khảo thêm tại code demo

    // }
    // public function vnpayReturn(Request $request)
    // {
    //     $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF";
    //     $inputData = $request->all();
    //     $vnp_SecureHash = $inputData['vnp_SecureHash'];
    //     unset($inputData['vnp_SecureHash']);
    //     ksort($inputData);
    //     $hashData = '';
    //     foreach ($inputData as $key => $value) {
    //         $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
    //     }
    //     $hashData = rtrim($hashData, '&');
    //     $computedHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    //     if ($computedHash === $vnp_SecureHash) {
    //         // Lưu thông tin giao dịch vào database
    //         $transaction = new Transaction();
    //         $transaction->txn_ref = $inputData['vnp_TxnRef'];
    //         $transaction->order_info = $inputData['vnp_OrderInfo'];
    //         $transaction->amount = $inputData['vnp_Amount'] / 100; // Chuyển đổi từ xu sang VND
    //         $transaction->status = ($inputData['vnp_ResponseCode'] == '00') ? 'success' : 'failed';
    //         $transaction->vnp_response_code = $inputData['vnp_ResponseCode'];
    //         $transaction->save();

    //         // Chuyển hướng đến trang thành công hoặc thất bại
    //         if ($inputData['vnp_ResponseCode'] == '00') {
    //             return view('client.vnpay.success', ['data' => $inputData]);
    //         } else {
    //             return view('client.vnpay.failed');
    //         }
    //     } else {
    //         return view('client.vnpay.invalid');
    //     }
    // }
}
