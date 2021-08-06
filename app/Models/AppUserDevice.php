<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\AppUserInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AppUser
 *
 * @package App\Models
 */
class AppUserDevice extends Model implements AppUserInterface
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_user_id',
        'device_id',
    ];

    /**
     * @var string
     */
    protected $table = 'app_user_devices';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appUser(): BelongsTo
    {
        return $this->belongsTo(AppUser::class, 'app_user_id', 'id');
    }
}
