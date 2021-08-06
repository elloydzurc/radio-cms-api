<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Exceptions;

use App\Exceptions\ConflictException;

/**
 * Class ProgramApiException
 *
 * @package App\Services\Api\Program\Exceptions
 */
final class ProgramApiException extends ConflictException
{
    /**
     * @param int $programId
     *
     * @return \App\Services\Api\Program\Exceptions\ProgramApiException
     */
    public static function programNotExists(int $programId): ProgramApiException
    {
        $message = trans('messages.program.not_exists', [
            'id' => $programId
        ]);

        return new self($message);
    }

    /**
     * @param int $stationId
     *
     * @return \App\Services\Api\Program\Exceptions\ProgramApiException
     */
    public static function programStationNotActive(int $stationId): ProgramApiException
    {
        $message = trans('messages.station.not_active', [
            'id' => $stationId
        ]);

        return new self($message);
    }

    /**
     * @param int $stationId
     *
     * @return \App\Services\Api\Program\Exceptions\ProgramApiException
     */
    public static function programStationNotExists(int $stationId): ProgramApiException
    {
        $message = trans('messages.station.not_exists', [
            'id' => $stationId
        ]);

        return new self($message);
    }
}
