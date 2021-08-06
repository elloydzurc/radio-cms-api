<?php
declare(strict_types=1);

namespace App\Http\Dto\Security;

use App\Http\Dto\AbstractDto;
use Illuminate\Support\Facades\Hash;

/**
 * Class ForgotPasswordRequestDto
 *
 * @package App\Http\Dto\Security
 */
final class ChangePasswordRequestDto extends AbstractDto
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $newPassword;

    /**
     * @var string
     */
    private string $password;

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
    public function getNewPassword(): string
    {
        return Hash::make($this->newPassword);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $email
     *
     * @return ChangePasswordRequestDto
     */
    public function setEmail(string $email): ChangePasswordRequestDto
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $newPassword
     *
     * @return ChangePasswordRequestDto
     */
    public function setNewPassword(string $newPassword): ChangePasswordRequestDto
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return ChangePasswordRequestDto
     */
    public function setPassword(string $password): ChangePasswordRequestDto
    {
        $this->password = $password;

        return $this;
    }
}
