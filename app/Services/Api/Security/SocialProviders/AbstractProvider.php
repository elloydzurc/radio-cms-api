<?php
declare(strict_types=1);

namespace App\Services\Api\Security\SocialProviders;

/**
 * Class AbstractProvider
 *
 * @package App\Services\Api\Security\SocialProviders
 */
abstract class AbstractProvider
{
    /**
     * @param null|string $name
     *
     * @return array
     */
    public function getFirstNameAndLastName(?string $name = null): array
    {
        $lastSpace = \strrpos($name, ' ');
        $firstName = \trim(\substr($name, 0, $lastSpace));
        $lastName = \substr($name, $lastSpace, strlen($name));

        return [$firstName, $lastName];
    }
}
