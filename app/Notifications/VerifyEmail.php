<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
// use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VerifyEmail as VerifyEmailOriginal;

class VerifyEmail extends VerifyEmailOriginal
{
    // use Queueable;

    protected function verificationUrl($notifiable) {
        $appUrl = config('app-client_url', config('app.url'));

        $url = URL::temporaySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(60),
                ['user' => $notifiable->id]
        );

        // laranuxt.test/api/ernibjl
        return str_replace(
            $url('/api'),
            $appUrl,
            $url
        );
    }


}
