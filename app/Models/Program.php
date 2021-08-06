<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\AdInterface;
use App\Models\Interfaces\ProgramInterface;
use App\Models\Pivots\AdProgram;
use App\Models\Pivots\ProgramStation;
use App\Traits\Searchable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * Class Program
 *
 * @package App\Models
 */
class Program extends Model implements ProgramInterface
{
    use CascadeSoftDeletes, HasEagerLimit, HasFactory, Searchable, SoftDeletes;

    /**
     * @var string[]
     */
    protected array $cascadeDeletes = [
        'contents'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'active',
    ];

    /**
     * @var array
     */
    protected array $searchable = [
        'name'
    ];

    /**
     * @var string
     */
    protected $table = 'programs';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class)
            ->using(AdProgram::class)
            ->where('section', '=', AdInterface::PROGRAM_SECTION);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents(): HasMany
    {
        $includeDeleted = $this->getAttribute('deleted_at') !== null;

        return $this->hasMany(Content::class, 'program_id', 'id')
            ->withTrashed($includeDeleted);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function featuredContent(): HasOne
    {
        return $this->hasOne(Content::class, 'program_id', 'id')
            ->where('featured', true)
            ->where('active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class)
            ->using(ProgramStation::class);
    }
}
