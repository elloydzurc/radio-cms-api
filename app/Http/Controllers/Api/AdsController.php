<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\ListAdsRequest;
use App\Services\Api\Ads\Interfaces\AdsProcessorResolverInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class AdsController
 *
 * @package App\Http\Controllers\Api
 */
final class AdsController extends Controller
{
    /**
     * @var \App\Services\Api\Ads\Interfaces\AdsProcessorResolverInterface
     */
    private AdsProcessorResolverInterface $processorResolver;

    /**
     * AdsController constructor.
     *
     * @param \App\Services\Api\Ads\Interfaces\AdsProcessorResolverInterface $processorResolver
     */
    public function __construct(AdsProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \App\Http\Requests\Ads\ListAdsRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function listAds(ListAdsRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }
}
