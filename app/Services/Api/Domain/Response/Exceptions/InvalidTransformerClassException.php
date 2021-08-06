<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Response\Exceptions;

use App\Exceptions\ErrorException;

/**
 * Class InvalidTransformerClassException
 *
 * @package App\Services\Api\Domain\Response\Exceptions
 */
class InvalidTransformerClassException extends ErrorException
{
    // No body needed
}
