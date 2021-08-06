<?php
declare(strict_types=1);

namespace App\Http\Dto\Security;

use App\Http\Dto\AbstractDto;
use Illuminate\Support\Facades\Hash;

/**
 * Class SignUpRequestDto
 *
 * @package App\Http\Dto\Security
 */
final class SignUpRequestDto extends AbstractDto
{
    /**
     * @var null|string
     */
    protected ?string $city;

    /**
     * @var \DateTime
     */
    protected \DateTime $dateOfBirth;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var string
     */
    protected string $firstName;

    /**
     * @var string
     */
    protected string $gender;

    /**
     * @var string
     */
    protected string $lastName;

    /**
     * @var string
     */
    protected string $password;

    /**
     * @var null|string
     */
    protected ?string $region;

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function getLastName(): string
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
    public function getPassword(): string
    {
        return Hash::make($this->password);
    }

    /**
     * @return string
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }
}
