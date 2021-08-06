<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\EmptyRequest;
use App\Http\Requests\Security\ChangePasswordRequest;
use App\Http\Requests\Security\ForgotPasswordRequest;
use App\Http\Requests\Security\LoginRequest;
use App\Http\Requests\Security\SignUpRequest;
use App\Http\Requests\Security\SingleSignOnRequest;
use App\Services\Api\Security\Interfaces\SecurityProcessorResolverInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class SecurityController
 *
 * @package App\Http\Controllers\Api
 */
final class SecurityController extends Controller
{
    /**
     * @var \App\Services\Api\Security\Interfaces\SecurityProcessorResolverInterface
     */
    private SecurityProcessorResolverInterface $processorResolver;

    /**
     * SecurityController constructor.
     *
     * @param \App\Services\Api\Security\Interfaces\SecurityProcessorResolverInterface $processorResolver
     */
    public function __construct(SecurityProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \App\Http\Requests\Security\ChangePasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Security\ForgotPasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Security\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Common\EmptyRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function logout(EmptyRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Security\SignUpRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Security\SingleSignOnRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function singleSignOn(SingleSignOnRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }
}
