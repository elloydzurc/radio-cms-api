<?php
declare(strict_types=1);

namespace App\Notifications\Api;

use App\Models\Interfaces\ContentInterface;
use App\Models\PushNotification;
use App\Traits\ImageAwareTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

/**
 * Class UserVerificationNotification
 *
 * @package App\Notifications\Cms
 */
class MobilePushNotification extends Notification implements ShouldQueue
{
    use ImageAwareTrait, Queueable;

    /**
     * @var \App\Models\PushNotification
     */
    private PushNotification $pushNotification;

    public function __construct(PushNotification $pushNotification)
    {
        $this->pushNotification = $pushNotification;
    }

    /**
     * @param $notifiable
     *
     * @return \NotificationChannels\Fcm\FcmMessage
     */
    public function toFcm($notifiable): FcmMessage
    {
        $data = $this->getNotificationData();
        $message = FcmMessage::create();

        if ($data !== null) {
            $message->setData($data);
        }

        $message->setNotification($this->createNotificationMessage())
            ->setAndroid($this->androidConfig())
            ->setApns($this->appleConfig());

        return $message;
    }

    /**
     * @param $notifiable
     *
     * @return string[]
     */
    public function via($notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * @return \NotificationChannels\Fcm\Resources\AndroidConfig
     */
    private function androidConfig(): AndroidConfig
    {
        $notification = AndroidNotification::create()
            ->setColor('#0A0A0A');
        $fcmOptions = AndroidFcmOptions::create()
            ->setAnalyticsLabel('analytics');

        return AndroidConfig::create()
            ->setFcmOptions($fcmOptions)
            ->setNotification($notification);
    }

    /**
     * @return \NotificationChannels\Fcm\Resources\ApnsConfig
     */
    private function appleConfig(): ApnsConfig
    {
        $fcmOptions = ApnsFcmOptions::create()
            ->setAnalyticsLabel('analytics_ios');

        return ApnsConfig::create()
            ->setFcmOptions($fcmOptions);
    }

    /**
     * @return \NotificationChannels\Fcm\Resources\Notification
     */
    private function createNotificationMessage(): FcmNotification
    {
        return FcmNotification::create()
            ->setTitle($this->pushNotification->getAttribute('name'))
            ->setBody($this->pushNotification->getAttribute('description'))
            ->setImage($this->getDefaultImage());
    }

    /**
     * @return null|array
     */
    private function getNotificationData(): ?array
    {
        $content = $this->pushNotification->getRelation('content');

        if ($content !== null) {
            return [
                'id' => (string)$this->pushNotification->getAttribute('id'),
                'content_id' => (string)$content->getAttribute('id'),
                'format' => \in_array(
                    $content->getAttribute('format'),
                    ContentInterface::ALL_VIDEO_FORMAT, true
                ) === true ? 'video' : 'audio',
            ];
        }

        return null;
    }
}
