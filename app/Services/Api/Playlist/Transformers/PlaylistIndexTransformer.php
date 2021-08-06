<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Transformers;

use App\Models\Playlist;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

/**
 * Class PlaylistIndexTransformer
 *
 * @package App\Services\Api\Playlist\Transformers
 */
class PlaylistIndexTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

    /**
     * @param \App\Models\Playlist $playlist
     *
     * @return array
     */
    public function transform(Playlist $playlist): array
    {
        $thumbnails = [];
        $tempThumbnails[] = $this->getDefaultImage();

        $contents = $playlist->getRelation('contents');

        if ($contents !== null && $contents->count() > 0) {
            $tempThumbnails = [];
            /** @var \App\Models\Content $content */
            foreach ($contents as $content) {
                $tempThumbnails[] = $content->getAttribute('thumbnail');
            }
        }

        foreach ($tempThumbnails as $thumbnail) {
            $thumbnails[] = Storage::exists($thumbnail) === true ? Storage::url($thumbnail) : $thumbnail;
        }

        return [
            'id' => $playlist->getAttribute('id'),
            'name' => $playlist->getAttribute('name'),
            'contents_count' => $playlist->getAttribute('contents_count'),
            'thumbnails' => $thumbnails
        ];
    }
}
