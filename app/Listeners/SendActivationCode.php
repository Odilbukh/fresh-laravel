<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\ActivationCodeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationCode implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;

        $code = rand(1000, 9999);

        $user->activation_code = $code;
        $user->save();

        Mail::to($user->email)->send(
            new ActivationCodeMail($code)
        );
    }
}
