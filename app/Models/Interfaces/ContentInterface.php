<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface ContentInterface
 *
 * @package App\Models\Interfaces
 */
interface ContentInterface extends BaseModelInterface
{
    /**
     * @var array
     */
    public const ALL_AUDIO_FORMAT = [
        self::FORMAT_AUDIO,
        self::FORMAT_PODCAST
    ];

    /**
     * @var array
     */
    public const ALL_VIDEO_FORMAT = [
        self::FORMAT_VIDEO,
        self::FORMAT_YOUTUBE
    ];

    /**
     * @var array
     */
    public const CONTENT_FORMATS = [
        self::FORMAT_AUDIO => 'Audio File',
        self::FORMAT_VIDEO => 'Video File',
        self::FORMAT_YOUTUBE => 'Youtube Link',
        self::FORMAT_PODCAST => 'Podcast Link'
    ];

    /**
     * @var array
     */
    public const CONTENT_TYPES = [
        self::TYPE_ON_DEMAND => 'On Demand',
        self::TYPE_LIVE => 'Live'
    ];

    /**
     * @var array
     */
    public const FILE_FORMAT = [
        self::FORMAT_AUDIO,
        self::FORMAT_VIDEO
    ];

    /**
     * @var string
     */
    public const FORMAT_AUDIO = 'audio';

    /**
     * @var string
     */
    public const FORMAT_PODCAST = 'podcast';

    /**
     * @var string
     */
    public const FORMAT_VIDEO = 'video';

    /**
     * @var string
     */
    public const FORMAT_YOUTUBE = 'youtube';

    /**
     * @var array
     */
    public const LINK_FORMAT = [
        self::FORMAT_PODCAST,
        self::FORMAT_YOUTUBE
    ];

    /**
     * @var string
     */
    public const TYPE_ON_DEMAND = 'on-demand';

    /**
     * @var string
     */
    public const TYPE_LIVE = 'live';
}
