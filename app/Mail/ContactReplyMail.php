<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $reply;

    public function __construct(Contact $contact, $reply)
    {
        $this->contact = $contact;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Your Inquiry Response')
                    ->view('emails.contact.reply'); // Create this view for the email content
    }
}