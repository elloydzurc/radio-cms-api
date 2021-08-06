<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\AdInterface;
use App\Models\Pivots\AdContent;
use App\Models\Pivots\AdProgram;
use App\Models\Pivots\AdStation;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * Class Ad
 *
 * @package App\Models
 */
class Ad extends Model implements AdInterface, HasMedia
{
    use CascadeSoftDeletes, HasEagerLimit, HasFactory, InteractsWithMedia, SoftDeletes;

    /**
     * @var array
     */
    protected array $cascadeDeletes = [
        'contents',
        'stations',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'duration_from' => 'date',
        'duration_to' => 'date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'code',
        'type',
        'duration_from',
        'duration_to',
        'location_type',
        'location',
        'section',
        'active',
    ];

    /**
     * @var string
     */
    protected $table = 'ads';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class)
            ->using(AdContent::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class)
            ->using(AdProgram::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class)
            ->using(AdStation::class);
    }
}
