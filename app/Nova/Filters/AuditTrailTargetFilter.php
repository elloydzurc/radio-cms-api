<?php
declare(strict_types=1);

namespace App\Nova\Filters;

use App\Models\Interfaces\AuditTrailInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

/**
 * Class AuditTrailTargetFilter
 *
 * @package App\Nova\Filters
 */
class AuditTrailTargetFilter extends Filter
{
    /**
     * @var string $name
     */
    public $name = 'Target Filter';

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
            $query->where('target_type', '=', $value);
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

        foreach (AuditTrailInterface::TARGET_TYPES as $type) {
            $path = \explode('\\', $type);
            $class = \array_pop($path);
            $options[$class] = $type::$model;
        }

        return $options;
    }
}
