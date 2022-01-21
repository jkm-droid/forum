<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MemberSendEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::channel('daily')->info("member mail");
        Log::channel('daily')->info(implode('',$this->details));

        return $this->markdown('mail.member')
            ->from('no-reply@industrialisingafrica.com','The Forum')
            ->subject($this->details['subject'])
            ->with([
                'email'=>strstr($this->details['receiver'], '@',true),
                'details'=>$this->details,
            ]);
    }
}
