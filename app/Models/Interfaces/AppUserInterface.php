<?php
declare(strict_types=1);

namespace App\Models\Interfaces;

/**
 * Interface AppUserInterface
 *
 * @package App\Models\Interfaces
 */
interface AppUserInterface extends BaseModelInterface
{
    /**
     * @var string
     */
    public const GENDER_FEMALE = 'female';

    /**
     * @var string
     */
    public const GENDER_MALE = 'male';

    /**
     * @var array
     */
    public const GENDERS = [
        self::GENDER_FEMALE => 'Female',
        self::GENDER_MALE => 'Male'
    ];

    /**
     * @var string
     */
    public const PROVIDER_APPLE = 'apple';

    /**
     * @var string
     */
    public const PROVIDER_FACEBOOK = 'facebook';

    /**
     * @var string
     */
    public const PROVIDER_GOOGLE = 'google';

    /**
     * @var string
     */
    public const PROVIDER_APP = 'app';

    /**
     * @var array
     */
    public const PROVIDERS = [
        self::PROVIDER_APP => 'App',
        self::PROVIDER_APPLE => 'Apple',
        self::PROVIDER_FACEBOOK => 'Facebook',
        self::PROVIDER_GOOGLE => 'Google',
    ];

    /**
     * @var array
     */
    public const PROVIDERS_SOCIAL_MEDIA = [
        self::PROVIDER_APPLE => 'Apple',
        self::PROVIDER_FACEBOOK => 'Facebook',
        self::PROVIDER_GOOGLE => 'Google',
    ];
}
