<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface UserInterface
 *
 * @package App\Models\Interfaces
 */
interface BaseModelInterface
{
    /**
     * @var string
     */
    public const ACTIVE = 'Active';

    /**
     * @var string
     */
    public const INACTIVE = 'Inactive';

    /**
     * @var string
     */
    public const DELETED = 'Deleted';

    /**
     * @var array
     */
    public const INACTIVE_STATUSES = [
        self::INACTIVE,
        self::DELETED
    ];

    /**
     * @var array
     */
    public const ALL_STATUSES = [
        self::INACTIVE,
        self::ACTIVE,
        self::DELETED
    ];
}