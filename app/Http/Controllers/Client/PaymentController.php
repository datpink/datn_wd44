<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function vnpay()
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return";

        $vnp_TmnCode = "6NK2ISZ9"; //Mã website tại VNPAY
        $vnp_HashSecret = "65TDBHY5NLK43Y566EFLVM6ATI1X79YF"; //Chuỗi bí mật

        $vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
        $vnp_OrderInfo = "Thanh toán hóa đơn";
        $vnp_OrderType = "ZAIA Enterprise";
        $vnp_Amount = 10000 * 100;
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

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
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
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        header('Location: ' . $vnp_Url);
        exit();

        // vui lòng tham khảo thêm tại code demo

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
            // Lưu thông tin giao dịch vào database
            $transaction = new Transaction();
            $transaction->txn_ref = $inputData['vnp_TxnRef'];
            $transaction->order_info = $inputData['vnp_OrderInfo'];
            $transaction->amount = $inputData['vnp_Amount'] / 100; // Chuyển đổi từ xu sang VND
            $transaction->status = ($inputData['vnp_ResponseCode'] == '00') ? 'success' : 'failed';
            $transaction->vnp_response_code = $inputData['vnp_ResponseCode'];
            $transaction->save();

            // Chuyển hướng đến trang thành công hoặc thất bại
            if ($inputData['vnp_ResponseCode'] == '00') {
                return view('client.vnpay.success', ['data' => $inputData]);
            } else {
                return view('client.vnpay.failed');
            }
        } else {
            return view('client.vnpay.invalid');
        }
    }

}
