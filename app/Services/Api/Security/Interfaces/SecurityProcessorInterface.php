<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface SecurityProcessorInterface
 *
 * @package App\Services\Api\Security\Interfaces
 */
interface SecurityProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const CHANGE_PASSWORD_PROCESSOR = 'change_password';

    /**
     * @var string
     */
    public const FORGOT_PASSWORD_PROCESSOR = 'forgot_password';

    /**
     * @var string
     */
    public const LOGIN_PROCESSOR = 'login';

    /**
     * @var string
     */
    public const LOGOUT_PROCESSOR = 'logout';

    /**
     * @var string
     */
    public const SIGN_UP_PROCESSOR = 'sign_up';

    /**
     * @var string
     */
    public const SINGLE_SIGN_ON_PROCESSOR = 'single_sign_on';
}