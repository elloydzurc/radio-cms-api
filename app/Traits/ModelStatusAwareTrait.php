<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait ModelStatusAwareTrait
 *
 * @package App\Traits
 */
trait ModelStatusAwareTrait
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return bool
     */
    protected function isModelActive(Model $model): bool
    {
        $isActive = $model->getAttribute('active') === true;
        $notDeleted = $model->getAttribute('deleted_at') === null;
        $isVerified = true;

        if ($this->hasAttributes($model, 'email_verified_at') === true) {
            $isVerified = $model->getAttribute('email_verified_at') !== null;
        }

        return $isActive && $notDeleted && $isVerified;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $attribute
     *
     * @return bool
     */
    private function hasAttributes(Model $model, string $attribute): bool
    {
        return \array_key_exists($attribute, $model->getAttributes());
    }
}
