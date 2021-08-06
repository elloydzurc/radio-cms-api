<?php
declare(strict_types=1);

namespace App\Services\Api\Security;

use App\Repositories\Api\Interfaces\AppUserRepositoryInterface;
use App\Services\Api\Security\Interfaces\SocialAuthManagerInterface;
use App\Services\Api\Security\Interfaces\TokenManagerInterface;
use App\Traits\AppUserAwareTrait;
use App\Traits\ModelStatusAwareTrait;

/**
 * Class AbstractSecurityProcessor
 *
 * @package App\Services\Api\Security
 */
abstract class AbstractSecurityProcessor
{
    use AppUserAwareTrait, ModelStatusAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\AppUserRepositoryInterface
     */
    protected AppUserRepositoryInterface $appUserRepository;

    /**
     * @var \App\Services\Api\Security\Interfaces\TokenManagerInterface
     */
    protected TokenManagerInterface $tokenManager;

    /**
     * @var \App\Services\Api\Security\Interfaces\SocialAuthManagerInterface
     */
    protected SocialAuthManagerInterface $socialAuthManager;

    /**
     * AbstractSecurityProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\AppUserRepositoryInterface $appUserRepository
     * @param \App\Services\Api\Security\Interfaces\TokenManagerInterface $tokenManager
     * @param \App\Services\Api\Security\Interfaces\SocialAuthManagerInterface $socialAuthManager
     */
    public function __construct(
        AppUserRepositoryInterface $appUserRepository,
        TokenManagerInterface $tokenManager,
        SocialAuthManagerInterface $socialAuthManager
    ) {
        $this->appUserRepository = $appUserRepository;
        $this->tokenManager = $tokenManager;
        $this->socialAuthManager = $socialAuthManager;
    }
}
