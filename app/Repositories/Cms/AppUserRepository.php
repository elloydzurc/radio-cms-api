<?php
declare(strict_types=1);

namespace App\Repositories\Cms;

use App\Models\AppUser;
use App\Repositories\AbstractRepository;
use App\Repositories\Cms\Interfaces\AppUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

/**
 * Class UserRepository
 *
 * @package App\Repositories\Cms
 */
final class AppUserRepository extends AbstractRepository implements AppUserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param \App\Models\AppUser $model
     */
    public function __construct(AppUser $model)
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function countAppUser(): int
    {
        return $this->model->newQuery()
            ->withTrashed()
            ->select('id')
            ->get()
            ->count();
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getAppUsersByDateRange(string $from, string $to): Builder
    {
        return $this->model->newQuery()
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('id')
            ->toBase();
    }

    /**
     * @param array $appUserIdRange
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAppUsersByIdRange(array $appUserIdRange): Collection
    {
        return $this->model->newQuery()
            ->select('id')
            ->with('devices')
            ->where('active', '=', true)
            ->whereBetween('id', $appUserIdRange)
            ->whereHas('devices', function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->whereNotNull('device_id');
            }, '>', 0)
            ->get();
    }
}
