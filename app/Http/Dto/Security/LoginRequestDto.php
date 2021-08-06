<?php
declare(strict_types=1);

namespace App\Http\Dto\Security;

use App\Http\Dto\AbstractDto;

/**
 * Class LoginRequestData
 *
 * @package App\Http\Dto\Security
 */
final class LoginRequestDto extends AbstractDto
{
    /**
     * @var string
     */
    private string $deviceId;

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $password;

    /**
     * @return string
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $deviceId
     *
     * @return $this
     */
    public function setDeviceId(string $deviceId): LoginRequestDto
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return LoginRequestDto
     */
    public function setEmail(string $email): LoginRequestDto
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return LoginRequestDto
     */
    public function setPassword(string $password): LoginRequestDto
    {
        $this->password = $password;

        return $this;
    }
}
