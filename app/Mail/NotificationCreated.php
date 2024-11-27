<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated extends Mailable
{
    use SerializesModels;

    public $notification;

    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    public function build()
    {
        return $this->subject('New Notification Created')
                    ->view('emails.notification_created')
                    ->with([
                        'title' => $this->notification->title,
                        'description' => $this->notification->description,
                        'url' => $this->notification->url,
                    ]);
    }
}

