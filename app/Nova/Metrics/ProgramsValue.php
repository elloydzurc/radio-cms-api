<?php
declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\Program;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

/**
 * Class ProgramsValue
 *
 * @package App\Nova\Metrics
 */
class ProgramsValue extends Value
{
    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor(): DateTimeInterface
    {
        return now()->addMinutes(10);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Programs Created';
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [
            'TODAY' => __('Today'),
            7 => __('1 Week'),
            30 => __('30 Days'),
            365 => __('365 Days'),
            'ALL' => __('All Time'),
        ];
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'programs';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return \Laravel\Nova\Metrics\ValueResult
     */
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->count($request, Program::class);
    }
}
