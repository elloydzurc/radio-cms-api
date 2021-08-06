<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Common\Interfaces;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Interface RouteProcessorInterface
 *
 * @package App\Services\Api\Domain\Common\Interfaces
 */
interface ProcessorInterface
{
    /**
     *
     * @param \App\Http\Dto\AbstractDto $data
     *
     * @return \App\Services\Api\Domain\Response\Interfaces\ResponseInterface
     */
    public function process(AbstractDto $data): ResponseInterface;

    /**
     * @param string $processor
     *
     * @return bool
     */
    public function support(string $processor): bool;
}