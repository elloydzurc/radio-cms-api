<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Transformers;

use App\Models\Content;
use App\Services\Api\Program\Transformers\ProgramIndexTransformer;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

/**
 * Class ContentDetailsTransformer
 *
 * @package App\Services\Api\Content\Transformers
 */
class ContentDetailsTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'program'
    ];

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

        return [
            'id' => $content->getAttribute('id'),
            'name' => $content->getAttribute('name'),
            'description' => $content->getAttribute('description'),
            'thumbnail' => $thumbnail,
            'content_url' => $contentUrl,
            'format' => $content->getAttribute('format'),
            'type' => $content->getAttribute('type'),
            'age_restriction' => $content->getAttribute('age_restriction'),
            'broadcast_date' => Carbon::parse($content->getAttribute('broadcast_date'))->toDateTimeString(),
            'active' => $content->getAttribute('active'),
            'featured' => $content->getAttribute('featured'),
            'created_at' => Carbon::parse($content->getAttribute('created_at'))->toDateTimeString(),
            'updated_at' => Carbon::parse($content->getAttribute('updated_at'))->toDateTimeString(),
            'app_user_favorite' => $content->getAttribute('app_users_count') > 0
        ];
    }

    /**
     * @param \App\Models\Content $content
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    public function includeProgram(Content $content): ResourceAbstract
    {
        $resource = $this->null();
        $program = $content->getRelation('program');

        if ($program !== null) {
            $resource = $this->item($program, new ProgramIndexTransformer());
        }

        return $resource;
    }
}
