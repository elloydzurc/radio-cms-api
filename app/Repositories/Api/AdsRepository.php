<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Ads\ListAdsDto;
use App\Models\Ad;
use App\Models\Interfaces\AdInterface;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\AdsRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Class AdsRepository
 *
 * @package App\Repositories\Api
 */
class AdsRepository extends AbstractRepository implements AdsRepositoryInterface
{
    /**
     * AppUserRepository constructor.
     *
     * @param \App\Models\Ad $model
     */
    public function __construct(Ad $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Http\Dto\Ads\ListAdsDto $data
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAds(ListAdsDto $data): Collection
    {
        $id = $data->getId();
        $section = $data->getSection();
        $query = $this->model->newQuery();

        if (\in_array($section, AdInterface::VIA_RELATED_TABLE, true) === true) {
            $related = $section === AdInterface::CHANNEL_SECTION ? 'station' : $section;

            $query->whereHas(Str::plural($related), static function (Builder $query) use ($related, $id) {
                if ($id !== null) {
                    $query->where($related . '_id', '=', $id);
                }
            });
        }

        return $query->where('active', '=', true)
            ->whereDate('duration_from', '<=', Carbon::now())
            ->whereDate('duration_to', '>=', Carbon::now())
            ->where('section', '=', $section)
            ->inRandomOrder()
            ->get();
    }
}
