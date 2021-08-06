<?php
declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\Content;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

/**
 * Class ContentsPartition
 *
 * @package App\Nova\Metrics
 */
class ContentsPartition extends Partition
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
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'contents-partitions';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return \Laravel\Nova\Metrics\PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->count($request, Content::class, 'format')
            ->label(function ($value) {
                return \ucfirst($value);
            });
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Contents by Format';
    }
}
