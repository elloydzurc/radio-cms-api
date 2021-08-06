<?php
declare(strict_types=1);

namespace App\Http\Dto\Security;

use App\Http\Dto\AbstractDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SingleSignOnRequestDto
 *
 * @package App\Http\Dto\Security
 */
final class SingleSignOnRequestDto extends AbstractDto
{
    /**
     * @var string
     */
    protected string $accessToken;

    /**
     * @var null|string
     */
    protected ?string $avatar = null;

    /**
     * @var string
     */
    protected string $deviceId;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var null|string
     */
    protected ?string $firstName = null;

    /**
     * @var null|string
     */
    protected ?string $lastName = null;

    /**
     * @var string
     */
    protected string $provider;

    /**
     * @var string
     */
    private string $providerId;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

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
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return \sprintf('%s %s', $this->firstName, $this->lastName);
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getProviderId(): string
    {
        return $this->providerId;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @param string $deviceId
     */
    public function setDeviceId(string $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $providerId
     */
    public function setProviderId(string $providerId): void
    {
        $this->providerId = $providerId;
    }
}
