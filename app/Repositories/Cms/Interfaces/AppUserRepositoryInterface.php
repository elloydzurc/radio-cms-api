<?php
declare(strict_types=1);

namespace App\Repositories\Cms\Interfaces;

use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

/**
 * Interface AppUserRepositoryInterface
 *
 * @package App\Repositories\Cms\Interfaces
 */
interface AppUserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return int
     */
    public function countAppUser(): int;

    /**
     * @param string $from
     * @param string $to
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getAppUsersByDateRange(string $from, string $to): Builder;

    /**
     * @param array $appUserIdRange
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAppUsersByIdRange(array $appUserIdRange): Collection;
}