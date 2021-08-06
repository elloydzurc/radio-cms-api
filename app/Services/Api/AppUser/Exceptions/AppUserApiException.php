<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Exceptions;

use App\Exceptions\ConflictException;
use Throwable;

/**
 * Class AppUserApiException
 *
 * @package App\Services\Api\AppUser\Exceptions
 */
final class AppUserApiException extends ConflictException
{
    /**
     * @param int $appUser
     *
     * @return \App\Services\Api\AppUser\Exceptions\AppUserApiException
     */
    public static function notExists(int $appUser): AppUserApiException
    {
        $message = trans('messages.app_user.not_exists', [
            'id' => $appUser
        ]);

        return new self($message);
    }

    /**
     * @param int $appUser
     *
     * @return \App\Services\Api\AppUser\Exceptions\AppUserApiException
     */
    public static function unableToUploadAvatar(int $appUser, Throwable $throwable): AppUserApiException
    {
        $message = trans('messages.app_user.not_exists', [
            'id' => $appUser,
            'message' => $throwable->getMessage(),
        ]);

        return new self($message, 0, $throwable);
    }
}
