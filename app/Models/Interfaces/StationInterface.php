<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface UserInterface
 *
 * @package App\Models\Interfaces
 */
interface StationInterface extends BaseModelInterface
{
    /**
     * @var array
     */
    public const STATION_TYPES = [
        self::TYPE_RADIO => 'Radio',
        self::TYPE_TV => 'TV',
        self::TYPE_OTHERS => 'Others'
    ];

    /**
     * @var string
     */
    public const TYPE_OTHERS = 'others';

    /**
     * @var string
     */
    public const TYPE_RADIO = 'radio';

    /**
     * @var string
     */
    public const TYPE_TV = 'tv';
}