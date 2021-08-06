<?php
declare(strict_types=1);

namespace App\Nova\Filters;

use App\Models\Interfaces\StationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

/**
 * Class StationTypeFilter
 *
 * @package App\Nova\Filters
 */
class StationTypeFilter extends Filter
{
    /**
     * @var string $name
     */
    public $name = 'Type Filter';

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  Request  $request
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value): Builder
    {
        if ($value !== null) {
            $query->where('type', '=', $value);
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  Request  $request
     * @return array
     */
    public function options(Request $request): array
    {
        return [
            'Radio' => StationInterface::TYPE_RADIO,
            'TV' => StationInterface::TYPE_TV,
            'Others' => StationInterface::TYPE_OTHERS,
        ];
    }
}
