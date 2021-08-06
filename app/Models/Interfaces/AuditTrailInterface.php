<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

use App\Nova\AppUser;
use App\Nova\Permission;
use App\Nova\Role;
use App\Nova\Station;
use App\Nova\Content;
use App\Nova\User;

/**
 * Interface AuditTrailInterface
 *
 * @package App\Models\Interfaces
 */
interface AuditTrailInterface extends BaseModelInterface
{
    /**
     * @var array
     */
    public const ACTION_TYPES = [
        'Create',
        'Update',
        'Delete'
    ];

    /**
     * @var array
     */
    public const TARGET_TYPES = [
        AppUser::class,
        Permission::class,
        Role::class,
        Station::class,
        Content::class,
        User::class
    ];
}