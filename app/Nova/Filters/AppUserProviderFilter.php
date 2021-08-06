<?php
declare(strict_types=1);

namespace App\Nova\Filters;

use App\Models\Interfaces\AppUserInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

/**
 * Class AppUserProviderFilter
 *
 * @package App\Nova\Filters
 */
class AppUserProviderFilter extends Filter
{
    /**
     * @var string $name
     */
    public $name = 'Provider Filter';

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
            $query->where('provider', '=', $value);
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
        $options = [];

        foreach (AppUserInterface::PROVIDERS as $key => $type) {
            $options[$type] = $key;
        }

        return $options;
    }
}
