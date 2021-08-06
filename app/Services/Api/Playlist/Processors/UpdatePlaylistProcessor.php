<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Playlist\AbstractPlaylistProcessor;
use App\Services\Api\Playlist\Exceptions\PlaylistApiException;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface;

/**
 * Class DetailsStationContentProcessor
 *
 * @package App\Services\Api\StationContent\Processors
 */
final class UpdatePlaylistProcessor extends AbstractPlaylistProcessor implements PlaylistProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     * @var \App\Http\Dto\Playlist\UpdatePlaylistRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();
        $criteria = [
            'app_user_id' => $appUserId,
            'id' => $data->getPlaylistId()
        ];

        /** @var null|\App\Models\Playlist $playlist */
        $playlist = $this->playlistRepository->findOneByCriteria($criteria);

        if ($playlist === null) {
            throw PlaylistApiException::notExists();
        }

        if ($this->isModelActive($playlist) === false) {
            throw PlaylistApiException::notExists();
        }

        $criteria = [
            'app_user_id' => $appUserId,
            'name' => $data->getName()
        ];

        $crossCheckPlaylist = $this->playlistRepository->findOneByCriteria($criteria);

        if ($crossCheckPlaylist !== null) {
            if ($this->isModelActive($crossCheckPlaylist) === false) {
                throw PlaylistApiException::notExists();
            }

            $isSamePlaylist = $data->getPlaylistId() === $crossCheckPlaylist->getAttribute('id');

            if ($isSamePlaylist === false) {
                throw PlaylistApiException::nameExists($data->getName());
            }
        }

        $playlist = $this->playlistRepository->updatePlaylist($playlist, $data);

        return new DefaultResponse($playlist);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return PlaylistProcessorInterface::UPDATE_PLAYLIST_PROCESSOR === $processor;
    }
}
