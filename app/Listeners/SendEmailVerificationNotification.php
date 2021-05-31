<?php

namespace App\Listeners;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification as BaseSendEmailVerificationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerificationNotification extends BaseSendEmailVerificationNotification implements ShouldQueue
{
}
