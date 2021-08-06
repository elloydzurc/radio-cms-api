<?php
declare(strict_types=1);

namespace App\Http\Dto\Playlist;

use App\Http\Dto\AbstractDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreatePlaylistRequestDto
 *
 * @package App\Http\Dto\Playlist
 */
final class CreatePlaylistRequestDto extends AbstractDto
{
    /**
     * @var int
     */
    private int $appUserId;

    /**
     * @var string
     */
    private string $name;

    /**
     * @return int
     */
    public function getAppUserId(): int
    {
        return $this->appUserId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int $appUserId
     */
    public function setAppUserId(int $appUserId): void
    {
        $this->appUserId = $appUserId;
    }

    /**
     * @param string $name
     *
     * @return CreatePlaylistRequestDto
     */
    public function setName(string $name): CreatePlaylistRequestDto
    {
        $this->name = $name;

        return $this;
    }
}
