<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\AdInterface;
use App\Models\Interfaces\ContentInterface;
use App\Models\Pivots\AdContent;
use App\Models\Pivots\AppUserFavorites;
use App\Traits\Searchable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * Class StationContent
 *
 * @package App\Models
 */
class Content extends Model implements ContentInterface
{
    use CascadeSoftDeletes, HasEagerLimit, HasFactory, HasTags, Searchable, SoftDeletes;

    /**
     * @var array
     */
    protected array $cascadeDeletes = [
        'appUsers',
        'playlist',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'broadcast_date' => 'datetime',
        'featured' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'thumbnail',
        'age_restriction',
        'broadcast_date',
        'active',
        'format'
    ];

    /**
     * @var string
     */
    protected $table = 'contents';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class)
            ->using(AdContent::class)
            ->where('section', '=', AdInterface::CONTENT_SECTION);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'content_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appUsers(): BelongsToMany
    {
        return $this->belongsToMany(AppUser::class, 'app_user_favorites')
            ->using(AppUserFavorites::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function playlist(): BelongsToMany
    {
        return $this->belongsToMany(
            Playlist::class,
            'playlist_content',
            'content_id',
            'playlist_id',
            'id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pushNotifications(): HasMany
    {
        return $this->hasMany(PushNotification::class, 'content_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function target(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'target');
    }
}
