<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\AdInterface;
use App\Models\Interfaces\ContentInterface;
use App\Models\Interfaces\StationInterface;
use App\Models\Pivots\AdStation;
use App\Models\Pivots\ProgramStation;
use App\Traits\Searchable;
use Carbon\Carbon;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Station
 *
 * @package App\Models
 */
class Station extends Model implements StationInterface
{
    use CascadeSoftDeletes, HasFactory, Searchable, SoftDeletes;

    /**
     * @var string[]
     */
    protected array $cascadeDeletes = [
        'comments',
        'programs',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'broadcast_wave_url',
        'description',
        'logo',
        'type',
        'status',
        'featured'
    ];

    /**
     * @var string
     */
    protected $table = 'stations';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class)
            ->using(AdStation::class)
            ->where('section', '=', AdInterface::CHANNEL_SECTION);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function featuredContent(): HasOneThrough
    {
        return $this->hasOneThrough(
            Content::class,
            ProgramStation::class,
            'station_id',
            'program_id',
            'id',
            'program_id'
        )
            ->where('active', true)
            ->where('featured', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function liveContent(): HasOneThrough
    {
        return $this->hasOneThrough(
            Content::class,
            ProgramStation::class,
            'station_id',
            'program_id',
            'id',
            'program_id'
        )
            ->where('active', '=', true)
            ->where('type', '=', ContentInterface::TYPE_LIVE)
            ->where('broadcast_date', '<=', Carbon::now())
            ->orderBy('broadcast_date', 'DESC');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function programContents(): HasManyThrough
    {
        return $this->hasManyThrough(
            Content::class,
            ProgramStation::class,
            'station_id',
            'program_id',
            'id',
            'program_id'
        )
            ->where('active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class)
            ->using(ProgramStation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function target(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'target');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_stations',
            'station_id',
            'user_id',
            'id',
            'id',
        );
    }
}
