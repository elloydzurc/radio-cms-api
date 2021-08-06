<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Response\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

/**
 * Interface RouteResponseInterface
 *
 * @package App\Services\Response\Interfaces
 */
interface ResponseInterface
{
    /**
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function getEntity(): ?Model;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEntityArray(): JsonResponse;
}
