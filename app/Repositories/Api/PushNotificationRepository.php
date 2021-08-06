<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Common\ListRequestDto;
use App\Models\PushNotification;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\PushNotificationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PushNotificationRepository
 *
 * @package App\Repositories\Api
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
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listSentPushNotification(ListRequestDto $queryParams): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->with('content')
            ->orderBy('trigger_datetime', 'DESC')
            ->where('trigger_datetime', '<=', now())
            ->where('active', '=', true);

        return $query->paginate($queryParams->getPerPage());
    }
}
