<?php

namespace App\Jobs;

use App\Mail\MemberSendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $recipientEmail, $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipientEmail, $details)
    {
        $this->details = $details;
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new MemberSendEmail('joshwriter53@gmail.com', $this->details);
        Mail::to($this->recipientEmail)->send($email);
    }
}
