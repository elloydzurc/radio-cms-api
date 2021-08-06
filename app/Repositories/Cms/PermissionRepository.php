<?php
declare(strict_types=1);

namespace App\Repositories\Cms;

use App\Repositories\AbstractRepository;
use App\Repositories\Cms\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRepository
 *
 * @package App\Repositories\Cms
 */
final class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    /**
     * PermissionRepository constructor.
     *
     * @param \Spatie\Permission\Models\Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * @return Collection
     */
    public function getAllPermissionName(): Collection
    {
        return $this->model
            ->newQuery()
            ->select('name')
            ->get();
    }
}
