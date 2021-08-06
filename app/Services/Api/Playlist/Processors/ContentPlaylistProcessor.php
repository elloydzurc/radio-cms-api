<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Playlist\AbstractPlaylistProcessor;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface;
use App\Services\Api\Content\Transformers\ContentDetailsTransformer;
use Illuminate\Support\Arr;

/**
 * Class ContentPlaylistProcessor
 *
 * @package App\Services\Api\Playlist\Processors
 */
final class ContentPlaylistProcessor extends AbstractPlaylistProcessor implements PlaylistProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $dtoFilters = $data->getFilters();
        $playlistId = Arr::pull($dtoFilters, 'playlist_id');

        $filters = [
            'app_user_id' => $this->getCurrentUserId(),
            'playlist_id' => $playlistId
        ];

        $data->setFilters($dtoFilters);

        $paginator = $this->playlistRepository->contentOfPlaylist($data, $filters);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ContentDetailsTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return PlaylistProcessorInterface::CONTENTS_PLAYLIST_PROCESSOR === $processor;
    }
}
