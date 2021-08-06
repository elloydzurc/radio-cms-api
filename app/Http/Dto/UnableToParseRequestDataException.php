<?php
declare(strict_types=1);

namespace App\Http\Dto;

use App\Exceptions\ErrorException;

/**
 * Class UnableToParseRequestDataException
 *
 * @package App\Http\Requests\
 */
final class UnableToParseRequestDataException extends ErrorException
{
    // No body needed
}