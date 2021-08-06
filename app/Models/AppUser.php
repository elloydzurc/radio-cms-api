<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\AppUserInterface;
use App\Models\Pivots\AppUserFavorites;
use App\Traits\Searchable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class AppUser
 *
 * @package App\Models
 */
class AppUser extends Authenticatable implements AppUserInterface
{
    use CascadeSoftDeletes, HasApiTokens, HasFactory, Notifiable, Searchable, SoftDeletes;

    /**
     * @var array
     */
    protected array $cascadeDeletes = [
        'comments',
        'favorites',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'date_of_birth' => 'date',
        'password_expired' => 'boolean',
        'last_login' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'active',
        'avatar',
        'provider_id',
        'provider',
        'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var string
     */
    protected $table = 'app_users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'app_user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany(AppUserDevice::class, 'app_user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Content::class, 'app_user_favorites')
            ->using(AppUserFavorites::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class, 'app_user_id', 'id');
    }

    /**
     * @return array
     */
    public function routeNotificationForFcm(): array
    {
        return $this->devices()
            ->get('device_id')
            ->pluck('device_id')
            ->toArray();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function target(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'target');
    }
}
