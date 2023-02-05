<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppHelperMail extends Mailable
{
    use Queueable, SerializesModels;

    private $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_details)
    {
        $this->details = $_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.content_creation')
            ->from('no-reply@industrialisingafrica.com','The Forum')
            ->subject($this->details['subject'])
            ->with([
                'email'=>strstr($this->details['recipient_email'], '@',true),
                'details'=>$this->details,
            ]);
    }
}
