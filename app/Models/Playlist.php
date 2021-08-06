<?php
declare(strict_types=1);

namespace App\Models;

use App\Models\Interfaces\PlaylistInterface;
use App\Traits\Searchable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

/**
 * Class Playlist
 *
 * @package App\Models
 */
class Playlist extends Model implements PlaylistInterface
{
    use CascadeSoftDeletes, HasEagerLimit, HasFactory, Searchable, SoftDeletes;

    /**
     * @var array
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
        'app_user_id',
        'name',
        'active',
    ];

    /**
     * @var string
     */
    protected $table = 'playlists';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(
            Content::class,
            'playlist_content',
            'playlist_id',
            'content_id',
            'id',
            'id'
        );
    }
}
