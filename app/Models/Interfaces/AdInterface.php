<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface AdInterface
 *
 * @package App\Models\Interfaces
 */
interface AdInterface extends BaseModelInterface
{
    /**
     * @var string[]
     */
    public const AD_LOCATIONS = [
        self::LOCAL_AD => 'Local',
        self::NATIONAL_AD => 'National',
    ];

    /**
     * @var string[]
     */
    public const AD_TYPES = [
        self::BANNER_AD => 'Banner',
        self::POPUP_AD => 'Pop-up',
        self::SLIDER_AD => 'Slider',
    ];

    /**
     * @var string[]
     */
    public const ALL_AD_SECTIONS = [
        self::CHANNEL_SECTION => 'Channel',
        self::CONTENT_SECTION => 'Content',
        self::HOMEPAGE_SECTION => 'Homepage',
        self::PLAYLIST_SECTION => 'Playlist',
        self::PROGRAM_SECTION => 'Program',
    ];

    /**
     * @var string
     */
    public const BANNER_AD = 'banner';

    /**
     * @var string[]
     */
    public const BANNER_SECTIONS = [
        self::CHANNEL_SECTION => 'Channel',
        self::CONTENT_SECTION => 'Content',
        self::PROGRAM_SECTION => 'Program',
    ];

    /**
     * @var string
     */
    public const CHANNEL_SECTION = 'channel';

    /**
     * @var string
     */
    public const CONTENT_SECTION = 'content';

    /**
     * @var string
     */
    public const HOMEPAGE_SECTION = 'homepage';

    /**
     * @var string
     */
    public const LOCAL_AD = 'local';

    /**
     * @var string
     */
    public const NATIONAL_AD = 'national';

    /**
     * @var string
     */
    public const PLAYLIST_SECTION = 'playlist';

    /**
     * @var string
     */
    public const POPUP_AD = 'popup';

    /**
     * @var string[]
     */
    public const POPUP_SECTIONS = [
        self::HOMEPAGE_SECTION => 'Homepage',
        self::CHANNEL_SECTION => 'Channel',
        self::PROGRAM_SECTION => 'Program',
    ];

    /**
     * @var string
     */
    public const PROGRAM_SECTION = 'program';

    /**
     * @var string
     */
    public const SLIDER_AD = 'slider';

    /**
     * @var string[]
     */
    public const SLIDER_SECTIONS = [
        self::HOMEPAGE_SECTION => 'Homepage',
    ];

    /**
     * @var string[]
     */
    public const VIA_RELATED_TABLE = [
        self::CHANNEL_SECTION,
        self::CONTENT_SECTION,
        self::PROGRAM_SECTION
    ];
}
