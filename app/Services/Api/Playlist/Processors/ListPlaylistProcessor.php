<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Playlist\AbstractPlaylistProcessor;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface;
use App\Services\Api\Playlist\Transformers\PlaylistIndexTransformer;

/**
 * Class ListPlaylistProcessor
 *
 * @package App\Services\Api\Playlist\Processors
 */
final class ListPlaylistProcessor extends AbstractPlaylistProcessor implements PlaylistProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();

        $currentFilter = $data->getFilters();
        $currentFilter['app_user_id'] = $appUserId;
        $data->setFilters($currentFilter);

        $paginator = $this->playlistRepository->listPlaylist($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, PlaylistIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return PlaylistProcessorInterface::LIST_PLAYLIST_PROCESSOR === $processor;
    }
}
