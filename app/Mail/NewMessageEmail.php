<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessageEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $recipientEmail, $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipientEmail, $details)
    {
        $this->details = $details;
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.message_notification')
            ->from('no-reply@industrialisingafrica.com','industrialisingafrica.com')
            ->subject("New Reaction Notification")
            ->with([
                'email'=>strstr($this->recipientEmail, '@',true),
                'details'=>$this->details,
            ]);
    }
}
