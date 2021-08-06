<?php
declare(strict_types=1);

namespace App\Notifications\Api;

use App\Models\AppUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class UserVerificationNotification
 *
 * @package App\Notifications\Cms
 */
class AppUserForgotPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var AppUser $appUser
     */
    protected AppUser $appUser;

    /**
     * @var string $password
     */
    protected string $password;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\AppUser $appUser
     * @param string $password
     */
    public function __construct(AppUser $appUser, string $password)
    {
        $this->appUser = $appUser;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->markdown(
            'auth.app-user-forgot-password-email',
            [
                'appUser' => $this->appUser,
                'password' => $this->password
            ]
        )->subject('Temporary Password');
    }
}
