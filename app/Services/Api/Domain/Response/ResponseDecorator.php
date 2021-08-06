<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Response;

use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

/**
 * Class ResponseDecorator
 *
 * @package App\Services\Api\Domain\Response
 */
final class ResponseDecorator implements ResponseInterface
{
    /**
     * @var \App\Services\Api\Domain\Response\Interfaces\ResponseInterface
     */
    protected ResponseInterface $decorated;

    /**
     * RouteResponseDecorator constructor.
     *
     * @param \App\Services\Api\Domain\Response\Interfaces\ResponseInterface $routeResponse
     */
    public function __construct(ResponseInterface $routeResponse)
    {
        $this->decorated = $routeResponse;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEntityArray(): JsonResponse
    {
        return $this->decorated->getEntityArray();
    }

    /**
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): ?Model
    {
        return  $this->decorated->getEntity();
    }
}