<?php

namespace App\Listeners;

use App\Jobs\SendMailJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\URL;

class SendEmailVerification 
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $url = URL::temporarySignedRoute('verify-user', now()->addMinutes(60), [
            'code' => $event->data['verification_code']
        ]);

        SendMailJob::dispatch(['name' => $event->data['name'], 'email' => $event->data['email'], 'verification_code' => $event->data['verification_code'], 'url' => $url]);
    }
}
