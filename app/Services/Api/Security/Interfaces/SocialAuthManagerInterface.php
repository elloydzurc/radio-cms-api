<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Interfaces;

use App\Http\Dto\Security\SingleSignOnRequestDto;

/**
 * Interface TokenManagerInterface
 *
 * @package App\Services\Api\Security\Interfaces
 */
interface SocialAuthManagerInterface
{
    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     */
    public function getUserInfo(SingleSignOnRequestDto $data): void;
}
