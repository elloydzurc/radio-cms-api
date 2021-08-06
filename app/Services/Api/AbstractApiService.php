<?php
declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Support\Str;

/**
 * Class AbstractApiService
 *
 * @package App\Services\Api
 */
abstract class AbstractApiService
{
    /**
     * @param string $route
     *
     * @return string
     */
    public function getRouteName(string $route): string
    {
        $index = \strpos($route, '::') + 2;
        $len = \strlen($route);

        return  Str::snake(\substr($route, $index, $len));
    }
}