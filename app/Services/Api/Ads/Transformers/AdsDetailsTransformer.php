<?php
declare(strict_types=1);

namespace App\Services\Api\Ads\Transformers;

use App\Models\Ad;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class AdsDetailsTransformer
 *
 * @package App\Services\Api\Ads\Transformers
 */
class AdsDetailsTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

    /**
     * @param \App\Models\Ad $ads
     *
     * @return array
     */
    public function transform(Ad $ads): array
    {
        $data = [
            'id' => $ads->getAttribute('id'),
            'title' => $ads->getAttribute('title'),
            'code' => $ads->getAttribute('code'),
            'type' => $ads->getAttribute('type'),
            'duration_from' => Carbon::parse($ads->getAttribute('duration_from'))->toDateString(),
            'duration_to' => Carbon::parse($ads->getAttribute('duration_to'))->toDateString(),
            'location_type' => $ads->getAttribute('location_type'),
            'location' => $ads->getAttribute('location'),
            'section' => $ads->getAttribute('section'),
            'active' => $ads->getAttribute('active'),
        ];

        $assets = [];
        $medias = $ads->getMedia('assets');

        if ($medias !== null) {
            /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
            foreach ($medias as $media) {
                $assets[] = [
                    'image_url' => $media->getFullUrl(),
                    'link' => $media->getCustomProperty('url')
                ];
            }
        }

        $data['assets'] = $assets;

        return $data;
    }
}
