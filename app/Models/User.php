<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\UserInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail, UserInterface
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'last_login' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'active'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(
            Station::class,
            'user_stations',
            'user_id',
            'station_id',
            'id',
            'id',
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function target(): MorphMany
    {
        return $this->morphMany(AuditTrail::class, 'target');
    }
}
