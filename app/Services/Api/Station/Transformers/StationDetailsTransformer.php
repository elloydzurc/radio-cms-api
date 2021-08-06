<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Transformers;

use App\Models\Station;
use App\Traits\ImageAwareTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

/**
 * Class StationDetailsTransformer
 *
 * @package App\Services\Api\Station\Transformers
 */
class StationDetailsTransformer extends TransformerAbstract
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

        return [
            'id' => $station->getAttribute('id'),
            'name' => $station->getAttribute('name'),
            'broadcast_wave_url' => $station->getAttribute('broadcast_wave_url'),
            'logo' => $logo,
            'description' => $station->getAttribute('description'),
            'type' => $station->getAttribute('type'),
            'active' => $station->getAttribute('active'),
            'featured' => $station->getAttribute('featured'),
            'created_at' => Carbon::parse($station->getAttribute('created_at'))->toDateTimeString(),
            'updated_at' => Carbon::parse($station->getAttribute('updated_at'))->toDateTimeString(),
        ];
    }
}
