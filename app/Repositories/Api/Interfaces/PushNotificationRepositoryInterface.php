<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Common\ListRequestDto;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface PushNotificationRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface PushNotificationRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listSentPushNotification(ListRequestDto $queryParams): LengthAwarePaginator;
}
