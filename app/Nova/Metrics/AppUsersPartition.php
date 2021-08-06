<?php
declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\AppUser;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

/**
 * Class AppUsersPartition
 *
 * @package App\Nova\Metrics
 */
class AppUsersPartition extends Partition
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
        return 'app-users-partitions';
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
        return $this->count($request, AppUser::class, 'provider')
            ->label(function ($value) {
                return \ucfirst($value);
            });
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'App Users by Provider';
    }
}
