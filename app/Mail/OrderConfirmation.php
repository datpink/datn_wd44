<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    // Khởi tạo với đơn hàng
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Xây dựng nội dung email
    public function build()
    {
        return $this->from('no-reply@zaiaenterprise.com', 'ZAIA Enterprise') // Đổi tên người gửi và email
                    ->subject('Xác nhận đơn hàng') // Đổi tiêu đề email
                    ->view('emails.order_confirmation')
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
