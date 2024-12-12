<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $status;

    /**
     * Tạo một instance mới.
     */
    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Xây dựng email.
     */
    public function build()
    {
        return $this->subject('Cập nhật trạng thái đơn hàng')
            ->view('emails.order_status_updated')
            ->with([
                'order' => $this->order,
                'status' => $this->status,
            ]);
    }
}
