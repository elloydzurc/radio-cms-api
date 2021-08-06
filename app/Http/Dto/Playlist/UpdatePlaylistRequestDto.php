<?php
declare(strict_types=1);

namespace App\Http\Dto\Playlist;

use App\Http\Dto\AbstractDto;

/**
 * Class UpdatePlaylistRequestDto
 *
 * @package App\Http\Dto\Playlist
 */
final class UpdatePlaylistRequestDto extends AbstractDto
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $playlistId;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPlaylistId(): int
    {
        return $this->playlistId;
    }

    /**
     * @param string $name
     *
     * @return UpdatePlaylistRequestDto
     */
    public function setName(string $name): UpdatePlaylistRequestDto
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $playlistId
     *
     * @return UpdatePlaylistRequestDto
     */
    public function setPlaylistId(int $playlistId): UpdatePlaylistRequestDto
    {
        $this->playlistId = $playlistId;

        return $this;
    }
}
