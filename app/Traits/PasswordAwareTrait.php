<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait PasswordAwareTrait
 *
 * @package App\Traits
 */
trait PasswordAwareTrait
{
    /**
    /**
     * @return string
     */
    public function getPasswordValidation(): string
    {
        return 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&.+-]{8,}$/';
    }

    /**
     * @return string
     */
    public function getPasswordHelperText(): string
    {
        return 'At least 1 uppercase, 1 numeric and 1 special character. Minimum of 8 characters';
    }
}
