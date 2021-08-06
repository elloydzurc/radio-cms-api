<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Common\Interfaces;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Interface ProcessorResolverInterface
 *
 * @package App\Services\Api\Domain\Common\Interfaces
 */
interface ProcessorResolverInterface
{
    /**
     * @param string $processor
     * @param \App\Http\Dto\AbstractDto $requestDto
     *
     * @return \App\Services\Api\Domain\Response\Interfaces\ResponseInterface
     */
    public function resolve(string $processor, AbstractDto $requestDto): ResponseInterface;
}