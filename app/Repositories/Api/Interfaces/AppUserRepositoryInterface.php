<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\AppUser\UpdateAppUserDto;
use App\Http\Dto\AppUser\UploadAvatarAppUserDto;
use App\Http\Dto\Security\ChangePasswordRequestDto;
use App\Http\Dto\Security\ForgotPasswordRequestDto;
use App\Http\Dto\Security\SignUpRequestDto;
use App\Http\Dto\Security\SingleSignOnRequestDto;
use App\Models\AppUser;
use App\Repositories\AbstractRepositoryInterface;

/**
 * Interface AppUserRepository
 *
 * @package App\Repositories\Api\Interfaces
 */
interface AppUserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Models\AppUser $appUser
     * @param string $deviceId
     */
    public function addDevice(AppUser $appUser, string $deviceId): void;

    /**
     * @param \App\Models\AppUser $appUser
     * @param int $contentId
     */
    public function addFavorite(AppUser $appUser, int $contentId): void;

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\Security\ChangePasswordRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function changePassword(AppUser $appUser, ChangePasswordRequestDto $data): AppUser;

    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function createSingleSignOnData(SingleSignOnRequestDto $data): AppUser;

    /**
     * @param \App\Models\AppUser $appUser
     * @param string $deviceId
     */
    public function deleteDevice(AppUser $appUser, string $deviceId): void;

    /**
     * @param \App\Models\AppUser $appUser
     * @param int $contentId
     */
    public function deleteFavorite(AppUser $appUser, int $contentId): void;

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\Security\ForgotPasswordRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function forgotPassword(AppUser $appUser, ForgotPasswordRequestDto $data): AppUser;

    /**
     * @param \App\Http\Dto\Security\SignUpRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function signUp(SignUpRequestDto $data): AppUser;

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\AppUser\UpdateAppUserDto $data
     *
     * @return \App\Models\AppUser
     */
    public function updateData(AppUser $appUser, UpdateAppUserDto $data): AppUser;

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\AppUser\UploadAvatarAppUserDto $data
     *
     * @return \App\Models\AppUser
     */
    public function uploadAvatar(AppUser $appUser, UploadAvatarAppUserDto $data): AppUser;

    /**
     * @param int $appUserId
     *
     * @return null|\App\Models\AppUser
     */
    public function verifiedAppUser(int $appUserId): ?AppUser;
}
