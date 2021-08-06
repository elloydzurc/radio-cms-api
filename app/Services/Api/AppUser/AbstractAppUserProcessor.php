<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser;

use App\Repositories\Api\Interfaces\AppUserRepositoryInterface;
use App\Repositories\Api\Interfaces\ContentRepositoryInterface;
use App\Repositories\Api\Interfaces\PushNotificationRepositoryInterface;
use App\Services\Api\Domain\FileManager\Interfaces\FileManagerInterface;
use App\Traits\AppUserAwareTrait;
use App\Traits\ModelStatusAwareTrait;

/**
 * Class AbstractAppUserProcessor
 *
 * @package App\Services\Api\AppUser
 */
abstract class AbstractAppUserProcessor
{
    use AppUserAwareTrait, ModelStatusAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\AppUserRepositoryInterface
     */
    protected AppUserRepositoryInterface $appUserRepository;

    /**
     * @var \App\Services\Api\Domain\FileManager\Interfaces\FileManagerInterface
     */
    protected FileManagerInterface $fileManager;

    /**
     * @var \App\Repositories\Api\Interfaces\ContentRepositoryInterface
     */
    protected ContentRepositoryInterface $contentRepository;

    /**
     * @var \App\Repositories\Api\Interfaces\PushNotificationRepositoryInterface
     */
    protected PushNotificationRepositoryInterface $pushNotificationRepository;

    /**
     * AbstractAppUserProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\AppUserRepositoryInterface $appUserRepository
     * @param \App\Repositories\Api\Interfaces\ContentRepositoryInterface $contentRepository
     * @param \App\Services\Api\Domain\FileManager\Interfaces\FileManagerInterface $fileManager
     */
    public function __construct(
        AppUserRepositoryInterface $appUserRepository,
        ContentRepositoryInterface $contentRepository,
        FileManagerInterface $fileManager,
        PushNotificationRepositoryInterface $pushNotificationRepository
    ) {
        $this->appUserRepository = $appUserRepository;
        $this->contentRepository = $contentRepository;
        $this->fileManager = $fileManager;
        $this->pushNotificationRepository = $pushNotificationRepository;
    }
}
