<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\ListCommentRequest;
use App\Http\Requests\Comment\PostCommentRequest;
use App\Http\Requests\Common\ListRequest;
use App\Services\Api\Comment\Interfaces\CommentProcessorResolverInterface;
use Illuminate\Http\JsonResponse;

/**
 * Class CommentController
 *
 * @package App\Http\Controllers\Api
 */
final class CommentController extends Controller
{
    /**
     * @var \App\Services\Api\Comment\Interfaces\CommentProcessorResolverInterface
     */
    private CommentProcessorResolverInterface $processorResolver;

    /**
     * CommentController constructor.
     *
     * @param \App\Services\Api\Comment\Interfaces\CommentProcessorResolverInterface $processorResolver
     */
    public function __construct(CommentProcessorResolverInterface $processorResolver)
    {
        $this->processorResolver = $processorResolver;
    }

    /**
     * @param \App\Http\Requests\Common\ListRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function listComment(ListRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }

    /**
     * @param \App\Http\Requests\Comment\PostCommentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function postComment(PostCommentRequest $request): JsonResponse
    {
        $response = $this->processorResolver->resolve(__METHOD__, $request->getData());

        return $response->getEntityArray();
    }
}
