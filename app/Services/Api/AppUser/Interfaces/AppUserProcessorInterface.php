<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface AppUserProcessorInterface
 *
 * @package App\Services\Api\AppUser\Interfaces
 */
interface AppUserProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const ADD_DEVICE_APP_USER_PROCESSOR = 'add_device_app_user';

    /**
     * @var string
     */
    public const ADD_FAVORITE_APP_USER_PROCESSOR = 'add_favorite_app_user';

    /**
     * @var string
     */
    public const DELETE_DEVICE_APP_USER_PROCESSOR = 'delete_device_app_user';

    /**
     * @var string
     */
    public const DELETE_FAVORITE_APP_USER_PROCESSOR = 'delete_favorite_app_user';

    /**
     * @var string
     */
    public const DETAILS_APP_USER_PROCESSOR = 'details_app_user';

    /**
     * @var string
     */
    public const INBOX_APP_USER_PROCESSOR = 'inbox_app_user';

    /**
     * @var string
     */
    public const LIST_FAVORITE_APP_USER_PROCESSOR = 'list_favorite_app_user';

    /**
     * @var string
     */
    public const UPDATE_APP_USER_PROCESSOR = 'update_app_user';

    /**
     * @var string
     */
    public const UPLOAD_AVATAR_APP_USER_PROCESSOR = 'upload_avatar_app_user';
}