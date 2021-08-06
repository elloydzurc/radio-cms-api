<?php
declare(strict_types=1);

namespace App\Services\Api\Ads\Exceptions;

use App\Exceptions\ConflictException;

/**
 * Class AdsApiException
 *
 * @package App\Services\Api\Ads\Exceptions
 */
final class AdsApiException extends ConflictException
{
    /**
     * @param string $section
     * @param int|null $adsId
     *
     * @return \App\Services\Api\Ads\Exceptions\AdsApiException
     */
    public static function notFound(string $section, ?int $adsId): AdsApiException
    {
        $message = trans('messages.ads.not_exists', [
            'section' => $section,
            'id' => $adsId
        ]);

        return new self($message);
    }
}
