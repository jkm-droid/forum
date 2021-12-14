<?php

namespace App\Jobs;

use App\Mail\AdminTopicMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AdminTopicJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $adminEmail, $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($adminEmail, $details)
    {
        $this->adminEmail = $adminEmail;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new AdminTopicMail($this->adminEmail, $this->details);
        Mail::to($this->adminEmail)->send($mail);
    }
}
