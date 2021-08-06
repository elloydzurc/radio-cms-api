<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface RoleInterface
 *
 * @package App\Models\Interfaces
 */
interface RoleInterface extends BaseModelInterface
{
    /**
     * @var string
     */
    public const ADMIN_ROLE = 'Admin';
}