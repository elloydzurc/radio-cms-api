<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\DetailsRequest;
use App\Http\Requests\Common\ListRequest;
use App\Services\Api\Program\Interfaces\ProgramProcessorResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ProgramController
 *
 * @package App\Http\Controllers\Api
 */
final class ProgramController extends Controller
{
    /**
     * @var \App\Services\Api\Program\Interfaces\ProgramProcessorResolverInterface
     */
    private ProgramProcessorResolverInterface $processorResolver;

    /**
     * StationController constructor.
     *
     * @param \App\Services\Api\Program\Interfaces\ProgramProcessorResolverInterface $processorResolver
     */
    public function __construct(ProgramProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $programId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsProgram(Request $request, int $programId): JsonResponse
    {
        $request['id'] = $programId;
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
    public function featuredContentProgram(ListRequest $request): JsonResponse
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
    public function listProgram(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $stationId
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function listStationProgram(Request $request, int $stationId): JsonResponse
    {
        /** @var \App\Http\Requests\Common\ListRequest $listRequest */
        $listRequest = app(ListRequest::class);

        /** @var \App\Http\Dto\Common\ListRequestDto $data */
        $data = $listRequest->getData();
        $data->addFilter('station_id', $stationId);

        $response = $this->processorResolver->resolve(__METHOD__, $data);

        return $response->getEntityArray();
    }
}
