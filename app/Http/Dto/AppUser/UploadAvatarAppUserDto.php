<?php
declare(strict_types=1);

namespace App\Http\Dto\AppUser;

use App\Http\Dto\AbstractDto;
use Illuminate\Http\UploadedFile;

/**
 * Class UploadAvatarAppUserDto
 *
 * @package App\Http\Dto\AppUser
 */
final class UploadAvatarAppUserDto extends AbstractDto
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var \Illuminate\Http\UploadedFile
     */
    private UploadedFile $avatar;

    /**
     * @var string|null
     */
    private ?string $avatarUrl = null;

    /**
     * @return \Illuminate\Http\UploadedFile
     */
    public function getAvatar(): UploadedFile
    {
        return $this->avatar;
    }

    /**
     * @return string|null
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $avatar
     *
     * @return UploadAvatarAppUserDto
     */
    public function setAvatar(UploadedFile $avatar): UploadAvatarAppUserDto
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @param string|null $avatarUrl
     *
     * @return UploadAvatarAppUserDto
     */
    public function setAvatarUrl(?string $avatarUrl): UploadAvatarAppUserDto
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }
}
