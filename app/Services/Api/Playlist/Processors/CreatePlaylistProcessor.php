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
final class CreatePlaylistProcessor extends AbstractPlaylistProcessor implements PlaylistProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     * @var \App\Http\Dto\Playlist\CreatePlaylistRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();
        $data->setAppUserId($appUserId);

        $criteria = [
            'app_user_id' => $appUserId,
            'name' => $data->getName()
        ];

        /** @var null|\App\Models\Playlist $playlist */
        $playlist = $this->playlistRepository->findOneByCriteria($criteria);

        if ($playlist !== null) {
            throw PlaylistApiException::alreadyExists($data->getName());
        }

        $playlist = $this->playlistRepository->createPlaylist($data);

        return new DefaultResponse($playlist);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return PlaylistProcessorInterface::CREATE_PLAYLIST_PROCESSOR === $processor;
    }
}
