<?php
declare(strict_types=1);

namespace App\Repositories\Cms;

use App\Models\PushNotification;
use App\Repositories\AbstractRepository;
use App\Repositories\Cms\Interfaces\PushNotificationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PushNotificationRepository
 *
 * @package App\Repositories\Cms
 */
final class PushNotificationRepository extends AbstractRepository implements PushNotificationRepositoryInterface
{
    /**
     * PushNotificationRepository constructor.
     *
     * @param \App\Models\PushNotification $pushNotification
     */
    public function __construct(PushNotification $pushNotification)
    {
        $this->model = $pushNotification;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivePushNotifications(): Collection
    {
        $currentDatetime = Carbon::now()->toDateTimeString('minute');
        $from = \sprintf('%s:00', $currentDatetime);
        $to = \sprintf('%s:59', $currentDatetime);

        return $this->model->newQuery()
            ->with('content')
            ->where('active', '=', true)
            ->whereBetween('trigger_datetime', [$from, $to])
            ->get();
    }
}
