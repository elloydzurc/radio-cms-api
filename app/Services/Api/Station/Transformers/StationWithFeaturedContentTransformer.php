<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Transformers;

use App\Models\Station;
use App\Services\Api\Content\Transformers\ContentIndexTransformer;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

/**
 * Class StationWithFeaturedContentTransformer
 *
 * @package App\Services\Api\Station\Transformers
 */
class StationWithFeaturedContentTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'featured_content'
    ];

    /**
     * @param \App\Models\Station $station
     *
     * @return array
     */
    public function transform(Station $station): array
    {
        $logo = $station->getAttribute('logo') ?? $this->getDefaultImage();

        if (Storage::exists($logo) === true) {
            $logo = Storage::url($logo);
        }

        return [
            'id' => $station->getAttribute('id'),
            'name' => $station->getAttribute('name'),
            'broadcast_wave_url' => $station->getAttribute('broadcast_wave_url'),
            'description' => $station->getAttribute('description'),
            'logo' => $logo,
            'type' => $station->getAttribute('type')
        ];
    }

    /**
     * @param \App\Models\Station $station
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    public function includeFeaturedContent(Station $station): ResourceAbstract
    {
        $resource = $this->null();
        $featuredContent = $station->getRelation('featuredContent');

        if ($featuredContent !== null) {
            $resource = $this->item($featuredContent, new ContentIndexTransformer());
        }

        return $resource;
    }
}
