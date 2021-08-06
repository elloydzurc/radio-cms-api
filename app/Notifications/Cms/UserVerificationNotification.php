<?php
declare(strict_types=1);

namespace App\Notifications\Cms;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserVerificationNotification
 *
 * @package App\Notifications\Cms
 */
class UserVerificationNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
}
