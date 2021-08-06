<?php
declare(strict_types=1);

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

/**
 * Class ContentAgeRestrictionFilter
 *
 * @package App\Nova\Filters
 */
class ContentAgeRestrictionFilter extends Filter
{
    /**
     * @var string $name
     */
    public $name = 'Age Restriction Filter';

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
            $query->where('age_restriction', '=', $value);
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
        $ageRestrictions = config('cms.age_restrictions');

        foreach ($ageRestrictions as $ageRestriction) {
            $options[$ageRestriction['name']] = $ageRestriction['code'];
        }

        return $options;
    }
}
