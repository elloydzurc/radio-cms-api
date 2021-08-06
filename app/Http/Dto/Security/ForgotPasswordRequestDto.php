<?php
declare(strict_types=1);

namespace App\Http\Dto\Security;

use App\Http\Dto\AbstractDto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class ForgotPasswordRequestDto
 *
 * @package App\Http\Dto\Security
 */
final class ForgotPasswordRequestDto extends AbstractDto
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var null|string
     */
    private ?string $newPassword = null;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return Hash::make($this->getNewPassword());
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        if ($this->newPassword === null) {
            $this->newPassword = Str::random(10);
        }

        return $this->newPassword;
    }

    /**
     * @param string $email
     *
     * @return ForgotPasswordRequestDto
     */
    public function setEmail(string $email): ForgotPasswordRequestDto
    {
        $this->email = $email;

        return $this;
    }
}
