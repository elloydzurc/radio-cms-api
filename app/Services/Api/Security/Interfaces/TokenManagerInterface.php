<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Interfaces;

use App\Models\AppUser;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Interface TokenManagerInterface
 *
 * @package App\Services\Api\Security\Interfaces
 */
interface TokenManagerInterface
{
    /**
     * @var string
     */
    public const API_TOKEN_NAME = 'radio_access_token_api';

    /**
     * @param \App\Models\AppUser $appUser
     *
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function grantToken(AppUser $appUser): PersonalAccessTokenResult;

    /**
     * @param \App\Models\AppUser $appUser
     *
     * @return bool
     */
    public function revokeToken(AppUser $appUser): bool;
}
