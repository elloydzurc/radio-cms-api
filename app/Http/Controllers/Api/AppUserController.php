<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppUser\DeviceAppUserRequest;
use App\Http\Requests\AppUser\FavoriteAppUserRequest;
use App\Http\Requests\AppUser\UpdateAppUserRequest;
use App\Http\Requests\AppUser\UploadAvatarAppUserRequest;
use App\Http\Requests\Common\DetailsRequest;
use App\Http\Requests\Common\ListRequest;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorResolverInterface;
use App\Traits\AppUserAwareTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AppUserController
 *
 * @package App\Http\Controllers\Api
 */
final class AppUserController extends Controller
{
    use AppUserAwareTrait;

    /**
     * @var \App\Services\Api\AppUser\Interfaces\AppUserProcessorResolverInterface
     */
    private AppUserProcessorResolverInterface $processorResolver;

    /**
     * AppUserController constructor.
     *
     * @param \App\Services\Api\AppUser\Interfaces\AppUserProcessorResolverInterface $processorResolver
     */
    public function __construct(AppUserProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDeviceAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $addDeviceRequest = app(DeviceAppUserRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $addDeviceRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addFavoriteAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $favoriteRequest = app(FavoriteAppUserRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $favoriteRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDeviceAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $addDeviceRequest = app(DeviceAppUserRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $addDeviceRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFavoriteAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $favoriteRequest = app(FavoriteAppUserRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $favoriteRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $detailRequest = app(DetailsRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $detailRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\ListRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function inboxAppUser(ListRequest $request): JsonResponse
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
    public function listFavoriteAppUser(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $updateRequest = app(UpdateAppUserRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $updateRequest->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAvatarAppUser(Request $request): JsonResponse
    {
        $request['id'] = $this->getCurrentUserId();

        $detailRequest = app(UploadAvatarAppUserRequest::class);

        $response = $this->processorResolver->resolve(__METHOD__, $detailRequest->getData());

        return $response->getEntityArray();
    }
}
