<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DetailsRequest;
use App\Http\Requests\Common\ListRequest;
use App\Services\Api\Content\Interfaces\ContentProcessorResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ContentController
 *
 * @package App\Http\Controllers\Api
 */
final class ContentController extends Controller
{
    /**
     * @var \App\Services\Api\Content\Interfaces\ContentProcessorResolverInterface
     */
    private ContentProcessorResolverInterface $processorResolver;

    /**
     * ContentController constructor.
     *
     * @param \App\Services\Api\Content\Interfaces\ContentProcessorResolverInterface $processorResolver
     */
    public function __construct(ContentProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $contentId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsContent(Request $request, int $contentId): JsonResponse
    {
        $request['id'] = $contentId;
        $detailsRequest = app(DetailsRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $detailsRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $programId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function listProgramContent(Request $request, int $programId): JsonResponse
    {
        /** @var \App\Http\Requests\Common\ListRequest $listRequest */
        $listRequest = app(ListRequest::class);

        /** @var \App\Http\Dto\Common\ListRequestDto $data */
        $data = $listRequest->getData();
        $data->addFilter('program_id', $programId);

        $response = $this->processorResolver->resolve(__METHOD__, $data);

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $contentId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tuneInContent(Request $request, int $contentId): JsonResponse
    {
        $request['filters'] = [
            'content_id' => $contentId
        ];

        $listRequest = app(ListRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $listRequest->getData());

        return $response->getEntityArray();
    }
}
