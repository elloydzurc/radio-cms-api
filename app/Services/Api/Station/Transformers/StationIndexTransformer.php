<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Transformers;

use App\Models\Station;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

/**
 * Class StationTransformer
 *
 * @package App\Services\Api\Station\Transformers
 */
class StationIndexTransformer extends TransformerAbstract
{
    use ImageAwareTrait;

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

        $data = [
            'id' => $station->getAttribute('id'),
            'name' => $station->getAttribute('name'),
            'broadcast_wave_url' => $station->getAttribute('broadcast_wave_url'),
            'description' => $station->getAttribute('description'),
            'logo' => $logo,
            'type' => $station->getAttribute('type'),
        ];

        if ($station->relationLoaded('liveContent') === true) {
            $liveContentId = null;

            if ($station->getRelation('liveContent') !== null) {
                $liveContentId = $station->getRelation('liveContent')->getAttribute('id');
            }

            $data['live_content_id'] = $liveContentId;
        }

        return $data;
    }
}
