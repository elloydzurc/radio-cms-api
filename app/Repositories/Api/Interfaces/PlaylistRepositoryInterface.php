<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Common\ListRequestDto;
use App\Http\Dto\Playlist\ContentToPlaylistRequestDto;
use App\Http\Dto\Playlist\CreatePlaylistRequestDto;
use App\Http\Dto\Playlist\UpdatePlaylistRequestDto;
use App\Models\Playlist;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface PlaylistRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface PlaylistRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Models\Playlist $playlist
     * @param \App\Http\Dto\Playlist\ContentToPlaylistRequestDto $data
     *
     * @return \App\Models\Playlist
     */
    public function addContentToPlaylist(Playlist $playlist, ContentToPlaylistRequestDto $data): Playlist;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     * @param array $filters
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function contentOfPlaylist(ListRequestDto $data, array $filters): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Playlist\CreatePlaylistRequestDto $data
     *
     * @return \App\Models\Playlist
     */
    public function createPlaylist(CreatePlaylistRequestDto $data): Playlist;

    /**
     * @param \App\Models\Playlist $playlist
     *
     * @return null|bool
     */
    public function deletePlaylist(Playlist $playlist): ?bool;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listPlaylist(ListRequestDto $data): LengthAwarePaginator;

    /**
     * @param \App\Models\Playlist $playlist
     * @param \App\Http\Dto\Playlist\ContentToPlaylistRequestDto $data
     *
     * @return int
     */
    public function removeContentToPlaylist(Playlist $playlist, ContentToPlaylistRequestDto $data): int;

    /**
     * @param \App\Models\Playlist $playlist
     * @param \App\Http\Dto\Playlist\UpdatePlaylistRequestDto $data
     *
     * @return \App\Models\Playlist
     */
    public function updatePlaylist(Playlist $playlist, UpdatePlaylistRequestDto $data): Playlist;
}
