<?php
declare(strict_types=1);

namespace App\Nova\Filters;

use App\Models\Interfaces\ContentInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

/**
 * Class ContentStatusFilter
 *
 * @package App\Nova\Filters
 */
class ContentStatusFilter extends Filter
{
    /**
     * @var string $name
     */
    public $name = 'Status Filter';

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
            $query->where('active', '=', $value);
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

        foreach (ContentInterface::ALL_STATUSES as $key => $status) {
            if ($status === ContentInterface::DELETED) {
                continue;
            }

            $options[$status] = $key;
        }

        return $options;
    }
}
