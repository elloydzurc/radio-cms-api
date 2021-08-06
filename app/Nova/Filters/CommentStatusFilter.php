<?php
declare(strict_types=1);

namespace App\Nova\Filters;

use App\Models\Interfaces\CommentInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

/**
 * Class CommentStatusFilter
 *
 * @package App\Nova\Filters
 */
class CommentStatusFilter extends Filter
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
        return [
            'Approved' => 1,
            'Not Approved' => 0
        ];
    }
}
