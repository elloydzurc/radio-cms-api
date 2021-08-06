<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DetailsRequest;
use App\Http\Requests\Common\ListRequest;
use App\Services\Api\Station\Interfaces\StationProcessorResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class StationController
 *
 * @package App\Http\Controllers\Api
 */
final class StationController extends Controller
{
    /**
     * @var \App\Services\Api\Station\Interfaces\StationProcessorResolverInterface
     */
    private StationProcessorResolverInterface $processorResolver;

    /**
     * StationController constructor.
     *
     * @param \App\Services\Api\Station\Interfaces\StationProcessorResolverInterface $processorResolver
     */
    public function __construct(StationProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $stationId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function detailsStation(Request $request, int $stationId): JsonResponse
    {
        $request['id'] = $stationId;

        /** @var \App\Http\Requests\Common\DetailsRequest $detailsRequest */
        $detailsRequest = app(DetailsRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $detailsRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\ListRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function featuredContentStation(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\ListRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function featuredStation(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\ListRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function listStation(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $stationId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tuneInStation(Request $request, int $stationId): JsonResponse
    {
        $request['filters'] = ['id' => $stationId];
        $request = app(ListRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }
}
