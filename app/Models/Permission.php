<?php
declare(strict_types=1);

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission
 *
 * @package App\Models
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    use CascadeSoftDeletes, HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected array $cascadeDeletes = [
        'roles'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function target(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'target');
    }
}
