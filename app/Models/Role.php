<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\RoleInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 *
 * @package App\Models
 */
class Role extends \Spatie\Permission\Models\Role implements RoleInterface
{
    use CascadeSoftDeletes, HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected array $cascadeDeletes = [
        'permissions'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function target(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'target');
    }
}
