<?php
declare(strict_types=1);

namespace App\Http\Dto\Playlist;

use App\Http\Dto\AbstractDto;

/**
 * Class ContentToPlaylistRequestDto
 *
 * @package App\Http\Dto\Playlist
 */
final class ContentToPlaylistRequestDto extends AbstractDto
{
    /**
     * @var int
     */
    private int $appUserId;

    /**
     * @var int
     */
    private int $contentId;

    /**
     * @var int
     */
    private int $playlistId;

    /**
     * @return int
     */
    public function getAppUserId(): int
    {
        return $this->appUserId;
    }

    /**
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }

    /**
     * @return int
     */
    public function getPlaylistId(): int
    {
        return $this->playlistId;
    }

    /**
     * @param int $appUserId
     */
    public function setAppUserId(int $appUserId): void
    {
        $this->appUserId = $appUserId;
    }

    /**
     * @param int $contentId
     *
     * @return ContentToPlaylistRequestDto
     */
    public function setContentId(int $contentId): ContentToPlaylistRequestDto
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * @param int $playlistId
     *
     * @return ContentToPlaylistRequestDto
     */
    public function setPlaylistId(int $playlistId): ContentToPlaylistRequestDto
    {
        $this->playlistId = $playlistId;

        return $this;
    }
}
