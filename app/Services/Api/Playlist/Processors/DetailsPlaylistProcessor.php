<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Playlist\AbstractPlaylistProcessor;
use App\Services\Api\Playlist\Exceptions\PlaylistApiException;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface;
use App\Services\Api\Playlist\Transformers\PlaylistDetailsTransformer;

/**
 * Class DetailsPlaylistProcessor
 *
 * @package App\Services\Api\Playlist\Processors
 */
final class DetailsPlaylistProcessor extends AbstractPlaylistProcessor implements PlaylistProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     * @var \App\Http\Dto\Common\DeleteRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();
        $criteria = [
            'app_user_id' => $appUserId,
            'id' => $data->getId()
        ];

        /** @var null|\App\Models\Playlist $playlist */
        $playlist = $this->playlistRepository->findOneByCriteria($criteria, [], ['contents']);

        if ($playlist === null) {
            throw PlaylistApiException::notExists();
        }

        if ($this->isModelActive($playlist) === false) {
            throw PlaylistApiException::notExists();
        }

        return new DefaultResponse($playlist, PlaylistDetailsTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return PlaylistProcessorInterface::DETAILS_PLAYLIST_PROCESSOR === $processor;
    }
}
