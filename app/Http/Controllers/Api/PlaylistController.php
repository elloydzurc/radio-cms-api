<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DeleteRequest;
use App\Http\Requests\Common\DetailsRequest;
use App\Http\Requests\Common\ListRequest;
use App\Http\Requests\Playlist\ContentToPlaylistRequest;
use App\Http\Requests\Playlist\CreatePlaylistRequest;
use App\Http\Requests\Playlist\UpdatePlaylistRequest;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class PlaylistController
 *
 * @package App\Http\Controllers\Api
 */
final class PlaylistController extends Controller
{
    /**
     * @var \App\Services\Api\Playlist\Interfaces\PlaylistProcessorResolverInterface
     */
    private PlaylistProcessorResolverInterface $processorResolver;

    /**
     * PlaylistController constructor.
     *
     * @param \App\Services\Api\Playlist\Interfaces\PlaylistProcessorResolverInterface $processorResolver
     */
    public function __construct(PlaylistProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \App\Http\Requests\Playlist\ContentToPlaylistRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function addContentToPlaylist(ContentToPlaylistRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Playlist\CreatePlaylistRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function createPlaylist(CreatePlaylistRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $playlistId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function contentsPlaylist(Request $request, int $playlistId): JsonResponse
    {
        /** @var \App\Http\Requests\Common\ListRequest $listRequest */
        $listRequest = app(ListRequest::class);

        /** @var \App\Http\Dto\Common\ListRequestDto $data */
        $data = $listRequest->getData();
        $data->addFilter('playlist_id', $playlistId);

        $response = $this->processorResolver->resolve(__METHOD__, $data);

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\DeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function deletePlaylist(DeleteRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $playlistId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsPlaylist(Request $request, int $playlistId): JsonResponse
    {
        $request['id'] = $playlistId;
        $request = app(DetailsRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\ListRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function listPlaylist(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Playlist\ContentToPlaylistRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function removeContentToPlaylist(ContentToPlaylistRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Playlist\UpdatePlaylistRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function updatePlaylist(UpdatePlaylistRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }
}
