<?php
declare(strict_types=1);

namespace App\Http\Dto\AppUser;

use App\Http\Dto\AbstractDto;

/**
 * Class AddDeviceAppUserDto
 *
 * @package App\Http\Dto\AppUser
 */
final class DeviceAppUserDto extends AbstractDto
{
    /**
     * @var string
     */
    protected string $deviceId;

    protected int $id;

    /**
     * @return string
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $deviceId
     */
    public function setDeviceId(string $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
