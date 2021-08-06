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
 * Class RemoveContentToPlaylistProcessor
 *
 * @package App\Services\Api\Playlist\Processors
 */
final class RemoveContentToPlaylistProcessor extends AbstractPlaylistProcessor implements PlaylistProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     * @var \App\Http\Dto\Playlist\ContentToPlaylistRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();
        $data->setAppUserId($appUserId);

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

        $success = $this->playlistRepository->removeContentToPlaylist($playlist, $data);

        if ($success === 0) {
            throw PlaylistApiException::unableToRemoveContent($data->getContentId());
        }

        return new DefaultResponse($playlist);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return PlaylistProcessorInterface::REMOVE_CONTENT_TO_PLAYLIST_PROCESSOR === $processor;
    }
}
