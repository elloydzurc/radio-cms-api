<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Exceptions;

use App\Exceptions\ConflictException;
use Throwable;

/**
 * Class SecurityException
 *
 * @package App\Services\Api\Security\Exceptions
 */
final class SecurityException extends ConflictException
{
    /**
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function userIdNotExists(): SecurityException
    {
        $message = trans('messages.security.user_id_not_exists');

        return new self($message);
    }

    /**
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function userEmailNotExists(): SecurityException
    {
        $message = trans('messages.security.user_not_exists');

        return new self($message);
    }

    /**
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function userNotActive(): SecurityException
    {
        $message = trans('messages.security.user_not_active');

        return new self($message);
    }

    /**
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function invalidPassword(): SecurityException
    {
        $message = trans('messages.security.invalid_password');

        return new self($message);
    }

    /**
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function userEmailExists(): SecurityException
    {
        $message = trans('messages.security.user_exists');

        return new self($message);
    }

    /**
     * @param string $provider
     * @param \Throwable $throwable
     *
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function invalidAccessToken(string $provider, Throwable $throwable): SecurityException
    {
        $message = trans('messages.security.invalid_access_token', [
            'provider' => $provider,
        ]);

        return new self($message, 0, $throwable);
    }

    /**
     * @param string $provider
     *
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function invalidSocialProvider(string $provider): SecurityException
    {
        $message = trans('messages.security.invalid_social_provide', [
            'provider' => $provider,
        ]);

        return new self($message);
    }

    /**
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function authenticationFailed(): SecurityException
    {
        $message = trans('messages.security.invalid_credentials');

        return new self($message);
    }

    /**
     * @param int $userId
     *
     * @return \App\Services\Api\Security\Exceptions\SecurityException
     */
    public static function unableToRevokeToken(int $userId): SecurityException
    {
        $message = trans('messages.security.unable_to_revoke_token', [
            'id' => $userId,
        ]);

        return new self($message);
    }
}
