<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Common\Exceptions;

use App\Exceptions\ErrorException;

/**
 * Class UnsupportedRouteException
 *
 * @package App\Services\Api\Domain\Common\Exceptions
 */
final class UnsupportedProcessorException extends ErrorException
{
    // No body needed
}