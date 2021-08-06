<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Transformers;

use App\Models\Interfaces\ContentInterface;
use App\Models\Content;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

/**
 * Class ContentIndexTransformer
 *
 * @package App\Services\Api\Content\Transformers
 */
class ContentIndexTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

    /**
     * @param \App\Models\Content $content
     *
     * @return array
     */
    public function transform(Content $content): array
    {
        $thumbnail = $content->getAttribute('thumbnail') ?? $this->getDefaultImage();

        if (Storage::exists($thumbnail) === true) {
            $thumbnail = Storage::url($thumbnail);
        }

        $contentUrl = $content->getAttribute('content_url') ?? '';
        $contentUrl = Storage::exists($contentUrl) ? Storage::url($contentUrl) : $contentUrl;

        $format = $content->getAttribute('format');
        $page = \in_array($format, ContentInterface::ALL_VIDEO_FORMAT, true) === true ? 'video' : 'audio';

        return [
            'id' => $content->getAttribute('id'),
            'name' => $content->getAttribute('name'),
            'description' => $content->getAttribute('description'),
            'thumbnail' => $thumbnail,
            'content_url' => $contentUrl,
            'format' => $format,
            'type' => $content->getAttribute('type'),
            'featured' => $content->getAttribute('featured'),
            'broadcast_date' => Carbon::parse($content->getAttribute('broadcast_date'))->toDateTimeString(),
            'landing_page' => $page . '_livestream_page',
            'app_user_favorite' => $content->getAttribute('app_users_count') > 0
        ];
    }
}
