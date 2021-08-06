<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\AdInterface;
use App\Models\Interfaces\PushNotificationInterface;
use App\Nova\Filters\PushNotificationStatusFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

/**
 * Class PushNotification
 *
 * @package App\Nova
 */
class PushNotification extends Resource
{
    /**
     * @var string
     */
    public static $group = 'Content Management';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PushNotification::class;

    /**
     * @var int
     */
    public static $priority = 5;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Model relationship
     *
     * @var array $with
     */
    public static $with = [
        'content',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name')
                ->sortable()
                ->creationRules('required', 'max:255', 'unique:push_notifications,name')
                ->updateRules('required', 'unique:push_notifications,name,{{resourceId}}'),

            Textarea::make('Description', 'description')
                ->alwaysShow()
                ->hideFromIndex()
                ->rows(3)
                ->rules('required'),

            BelongsTo::make('Episode', 'content', Content::class)
                ->nullable(),

            DateTime::make('Trigger Datetime', 'trigger_datetime')
                ->rules('required', 'after:' . Carbon::now()->addMinute()),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(PushNotificationInterface::INACTIVE_STATUSES)
                ->loadingWhen([])
                ->sortable(),

            Boolean::make('Status', 'active')
                ->onlyOnForms()
                ->hideWhenCreating(),

            DateTime::make('Deleted At', 'deleted_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->onlyOnDetail(),

            DateTime::make('Last Update', 'updated_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            DateTime::make('Created At', 'created_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->onlyOnDetail(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [
            resolve(PushNotificationStatusFilter::class),
        ];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return string
     */
    private function getStatus(Model $model): string
    {
        if ($model->getAttribute('deleted_at') !== null) {
            return AdInterface::DELETED;
        }

        return $model->getAttribute('active') ? AdInterface::ACTIVE : AdInterface::INACTIVE;
    }
}
