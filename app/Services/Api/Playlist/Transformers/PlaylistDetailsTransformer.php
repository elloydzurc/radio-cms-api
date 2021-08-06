<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Transformers;

use App\Models\Playlist;
use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class PlaylistDetailsTransformer
 *
 * @package App\Services\Api\Playlist\Transformers
 */
class PlaylistDetailsTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\Playlist $playlist
     *
     * @return array
     */
    public function transform(Playlist $playlist): array
    {
        return [
            'id' => $playlist->getAttribute('id'),
            'name' => $playlist->getAttribute('name'),
            'contents_count' => $playlist->getAttribute('contents_count'),
            'active' => $playlist->getAttribute('active'),
            'created_at' => Carbon::parse($playlist->getAttribute('created_at'))->toDateTimeString(),
            'updated_at' => Carbon::parse($playlist->getAttribute('updated_at'))->toDateTimeString(),
        ];
    }
}
