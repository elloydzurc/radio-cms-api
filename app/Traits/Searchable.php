<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait Searchable
 *
 * @package App\Traits
 */
trait Searchable
{
    /**
     * @return array
     */
    public function getSearchable(): array
    {
        return $this->searchable ?? [];
    }
}
