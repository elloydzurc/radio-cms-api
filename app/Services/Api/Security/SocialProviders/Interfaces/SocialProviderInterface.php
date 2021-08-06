<?php
declare(strict_types=1);

namespace App\Services\Api\Security\SocialProviders\Interfaces;

use App\Http\Dto\Security\SingleSignOnRequestDto;
use Laravel\Socialite\Two\User;

/**
 * Interface SocialProviderInterface
 *
 * @package App\Services\Api\Security\SocialProviders\Interfaces
 */
interface SocialProviderInterface
{
    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     * @param \Laravel\Socialite\Two\User $socialProviderData
     */
    public function parse(SingleSignOnRequestDto $data, User $socialProviderData): void;

    /**
     * @param string $provider
     *
     * @return bool
     */
    public function support(string $provider): bool;
}
