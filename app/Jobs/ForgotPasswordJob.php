<?php

namespace App\Jobs;

use App\Http\Controllers\Auth\MailController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    public $tries = 5;

    public $timeout = 30;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->queue = 'sendmail';
        $this->delay = now()->addSeconds(30);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        MailController::sendResetPasswordMail($this->data['email'], $this->data['token'], $this->data['url']);
    }
}
