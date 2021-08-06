<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Carbon;

/**
 * Trait DataTypeAwareTrait
 *
 * @package App\Traits
 */
trait DataTypeAwareTrait
{
    /**
     * @param string $type
     * @param $data
     *
     * @return mixed
     */
    private function convert(string $type, $data)
    {
        switch ($type) {
            case 'string':
                return (string) $data;
            case 'int':
                return filter_var($data, FILTER_VALIDATE_INT);
            case 'bool':
                return filter_var($data, FILTER_VALIDATE_BOOLEAN);
            case 'DateTime':
                return Carbon::parse($data);
            default:
                return $data;
        }
    }
}