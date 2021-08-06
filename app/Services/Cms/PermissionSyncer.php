<?php
declare(strict_types=1);

namespace App\Services\Cms;

use App\Repositories\Cms\Interfaces\PermissionRepositoryInterface;
use App\Services\Cms\Interfaces\PermissionSyncerInterface;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionSyncer
 *
 * @package App\Services\Cms
 */
final class PermissionSyncer implements PermissionSyncerInterface
{
    /**
     * @var \App\Repositories\Cms\Interfaces\PermissionRepositoryInterface
     */
    private PermissionRepositoryInterface $permissionRepository;

    /**
     * PermissionSyncer constructor.
     *
     * @param \App\Repositories\Cms\Interfaces\PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Sync all cms permissions
     */
    public function sync(): void
    {
        $allPermissions = Arr::flatten(config('cms.permissions'));
        $currentPermissions = $this->permissionRepository->getAllPermissionName()
            ->pluck('name')
            ->toArray();
        $missingPermissions = \array_diff($allPermissions, $currentPermissions);

        foreach ($missingPermissions as $permission) {
            $newPermissions = new Permission();
            $newPermissions->setAttribute('name', $permission);
            $newPermissions->setAttribute('guard_name', config('auth.defaults.guard'));

            $this->permissionRepository->save($newPermissions);
        }
    }
}
