<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\AppUser\UpdateAppUserDto;
use App\Http\Dto\AppUser\UploadAvatarAppUserDto;
use App\Http\Dto\Security\ChangePasswordRequestDto;
use App\Http\Dto\Security\ForgotPasswordRequestDto;
use App\Http\Dto\Security\SignUpRequestDto;
use App\Http\Dto\Security\SingleSignOnRequestDto;
use App\Models\AppUser;
use App\Models\Interfaces\AppUserInterface;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\AppUserRepositoryInterface;
use Illuminate\Support\Carbon;

/**
 * Class AppUserRepository
 *
 * @package App\Repositories\Api
 */
class AppUserRepository extends AbstractRepository implements AppUserRepositoryInterface
{
    /**
     * AppUserRepository constructor.
     *
     * @param \App\Models\AppUser $model
     */
    public function __construct(AppUser $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param string $deviceId
     */
    public function addDevice(AppUser $appUser, string $deviceId): void
    {
        $appUser->devices()->updateOrCreate(
            ['device_id' => $deviceId],
            ['app_user_id' => $appUser->getAttribute('id')]
        );
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param int $contentId
     */
    public function addFavorite(AppUser $appUser, int $contentId): void
    {
        $appUser->favorites()->syncWithoutDetaching([
            $contentId => ['date_added' => \now()]
        ]);
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\Security\ChangePasswordRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function changePassword(AppUser $appUser, ChangePasswordRequestDto $data): AppUser
    {
        $appUser->setAttribute('password', $data->getNewPassword());
        $appUser->setAttribute('password_expired', 0);

        $this->save($appUser);

        return $appUser;
    }

    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function createSingleSignOnData(SingleSignOnRequestDto $data): AppUser
    {
        $this->model->setAttribute('avatar', $data->getAvatar());
        $this->model->setAttribute('name', $data->getName());
        $this->model->setAttribute('first_name', $data->getFirstName());
        $this->model->setAttribute('last_name', $data->getLastName());
        $this->model->setAttribute('email', $data->getEmail());
        $this->model->setAttribute('provider', $data->getProvider());
        $this->model->setAttribute('provider_id', $data->getProviderId());
        $this->model->setAttribute('active', true);
        $this->model->setAttribute('email_verified_at', Carbon::now());
        $this->model->setAttribute('password_expired', false);

        $this->save($this->model);

        return $this->model;
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param string $deviceId
     */
    public function deleteDevice(AppUser $appUser, string $deviceId): void
    {
        $appUser->devices()->newQuery()
            ->where('device_id', '=', $deviceId)
            ->delete();
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param int $contentId
     */
    public function deleteFavorite(AppUser $appUser, int $contentId): void
    {
        $appUser->favorites()->detach([$contentId]);
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\Security\ForgotPasswordRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function forgotPassword(AppUser $appUser, ForgotPasswordRequestDto $data): AppUser
    {
        $appUser->setAttribute('password', $data->getHashedPassword());
        $appUser->setAttribute('password_expired', true);

        $this->save($appUser);

        return $appUser;
    }

    /**
     * @param \App\Http\Dto\Security\SignUpRequestDto $data
     *
     * @return \App\Models\AppUser
     */
    public function signUp(SignUpRequestDto $data): AppUser
    {
        $this->model->setAttribute('name', $data->getName());
        $this->model->setAttribute('first_name', $data->getFirstName());
        $this->model->setAttribute('last_name', $data->getLastName());
        $this->model->setAttribute('email', $data->getEmail());
        $this->model->setAttribute('date_of_birth', $data->getDateOfBirth());
        $this->model->setAttribute('gender', $data->getGender());
        $this->model->setAttribute('password', $data->getPassword());
        $this->model->setAttribute('city', $data->getCity());
        $this->model->setAttribute('region', $data->getRegion());
        $this->model->setAttribute('provider', AppUserInterface::PROVIDER_APP);
        $this->model->setAttribute('active', false);

        $this->save($this->model);

        return $this->model;
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\AppUser\UpdateAppUserDto $data
     *
     * @return \App\Models\AppUser
     */
    public function updateData(AppUser $appUser, UpdateAppUserDto $data): AppUser
    {
        $appUser->setAttribute('first_name', $data->getFirstName());
        $appUser->setAttribute('last_name', $data->getLastName());
        $appUser->setAttribute('gender', $data->getGender());
        $appUser->setAttribute('date_of_birth', $data->getDateOfBirth());
        $appUser->setAttribute('name', $data->getName());
        $appUser->setAttribute('city', $data->getCity());
        $appUser->setAttribute('region', $data->getRegion());

        if ($appUser->isDirty() === true) {
            $appUser->save();
        }

        return $appUser;
    }

    /**
     * @param \App\Models\AppUser $appUser
     * @param \App\Http\Dto\AppUser\UploadAvatarAppUserDto $data
     *
     * @return \App\Models\AppUser
     */
    public function uploadAvatar(AppUser $appUser, UploadAvatarAppUserDto $data): AppUser
    {
        $appUser->setAttribute('avatar', $data->getAvatarUrl());
        $appUser->save();

        return $appUser;
    }

    /**
     * @param int $appUserId
     *
     * @return null|\App\Models\AppUser
     */
    public function verifiedAppUser(int $appUserId): ?AppUser
    {
        /** @var null|\App\Models\AppUser $appUser */
        $appUser = $this->find($appUserId);

        if ($appUser !== null) {
            $appUser->setAttribute('email_verified_at', Carbon::now());
            $appUser->setAttribute('active', true);

            $this->save($appUser);
        }

        return $appUser;
    }
}
