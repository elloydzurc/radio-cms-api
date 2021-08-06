<?php
declare(strict_types=1);

namespace App\Services\Api\Domain\Common\Serializers;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class DefaultSerializer
 *
 * @package App\Services\Api\Domain\Common\Serializers
 */
class DefaultSerializer extends ArraySerializer
{
    /**
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data): array
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    /**
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function item($resourceKey, array $data): array
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }

        return $data;
    }

    /**
     * Serialize null resource.
     *
     * @return null
     */
    public function null()
    {
        return null;
    }
}
