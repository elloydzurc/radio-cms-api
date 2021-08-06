<?php
declare(strict_types=1);

namespace App\Http\Dto\AppUser;

use App\Http\Dto\AbstractDto;

/**
 * Class UpdateAppUserDto
 *
 * @package App\Http\Dto\AppUser
 */
final class UpdateAppUserDto extends AbstractDto
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var null|string
     */
    private ?string $city = null;

    /**
     * @var \DateTime
     */
    private \DateTime $dateOfBirth;

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var null|string
     */
    private ?string $gender = null;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var null|string
     */
    private ?string $region = null;

    /**
     * @return null|string
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return null|string
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param null|string $city
     *
     * @return UpdateAppUserDto
     */
    public function setCity(?string $city = null): UpdateAppUserDto
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param \DateTime $dateOfBirth
     *
     * @return UpdateAppUserDto
     */
    public function setDateOfBirth(\DateTime $dateOfBirth): UpdateAppUserDto
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * @param string $firstName
     *
     * @return UpdateAppUserDto
     */
    public function setFirstName(string $firstName): UpdateAppUserDto
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param null|string $gender
     *
     * @return UpdateAppUserDto
     */
    public function setGender(?string $gender = null): UpdateAppUserDto
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return UpdateAppUserDto
     */
    public function setId(int $id): UpdateAppUserDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $lastName
     *
     * @return UpdateAppUserDto
     */
    public function setLastName(string $lastName): UpdateAppUserDto
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param null|string $region
     *
     * @return UpdateAppUserDto
     */
    public function setRegion(?string $region = null): UpdateAppUserDto
    {
        $this->region = $region;

        return $this;
    }
}
