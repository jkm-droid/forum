<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminTopicMail extends Mailable
{
    use Queueable, SerializesModels;

    private $adminEmail, $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($adminEmail, $details)
    {
        $this->adminEmail = $adminEmail;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.admin_topic')
            ->from('no-reply@industrialisingafrica.com','industrialisingafrica.com')
            ->subject("Invitation to become an Admin")
            ->with([
                'email'=>strstr($this->adminEmail, '@',true),
                'details'=>$this->details,
            ]);
    }
}
