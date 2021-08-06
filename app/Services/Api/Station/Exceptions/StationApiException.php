<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Exceptions;

use App\Exceptions\ConflictException;

/**
 * Class StationApiException
 *
 * @package App\Services\Api\Station\Exceptions
 */
final class StationApiException extends ConflictException
{
    /**
     * @param int $stationId
     *
     * @return \App\Services\Api\Station\Exceptions\StationApiException
     */
    public static function notFound(int $stationId): StationApiException
    {
        $message = trans('messages.station.not_exists', [
            'id' => $stationId
        ]);

        return new self($message);
    }
}
