<?php
declare(strict_types=1);

namespace App\Repositories\Cms\Interfaces;

use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PermissionRepositoryInterface
 *
 * @package App\Repositories\Cms\Interfaces
 */
interface PermissionRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllPermissionName(): Collection;
}
