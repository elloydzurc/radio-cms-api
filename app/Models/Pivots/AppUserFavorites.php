<?php
declare(strict_types=1);

namespace App\Models\Pivots;

use App\Models\AppUser;
use App\Models\Content;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class AppUserFavorites
 *
 * @package App\Models\Pivots
 */
class AppUserFavorites extends Pivot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appUser(): BelongsTo
    {
        return $this->belongsTo(AppUser::class, 'app_user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }
}
