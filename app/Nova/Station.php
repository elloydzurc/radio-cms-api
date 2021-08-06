<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\RoleInterface;
use App\Models\Interfaces\StationInterface;
use App\Nova\Actions\ExportStations;
use App\Nova\Filters\StationFeaturedFilter;
use App\Nova\Filters\StationStatusFilter;
use App\Nova\Filters\StationTypeFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class Station
 *
 * @package App\Nova
 */
class Station extends Resource
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
    public static $model = \App\Models\Station::class;

    /**
     * @var int
     */
    public static $priority = 1;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'type'
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
        'ads',
        'users',
        'programs',
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if ($user->hasRole(RoleInterface::ADMIN_ROLE) === false) {
            $query->whereHas('users', function (Builder $query) use ($user) {
                $query->where('user_id', $user->getAttribute('id'));
            });
        }

        return $query;
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Channels';
    }

    /**
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'Channel';
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            (new ExportStations())
                ->allFields()
                ->askForFilename()
                ->canSee(function () use ($request) {
                    return $request->get('viaResource') === 'reports';
                }),
        ];
    }

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

            Text::make('Channel Name', 'name')
                ->sortable()
                ->creationRules('required', 'max:255', 'unique:stations,name')
                ->updateRules('required', 'max:255', 'unique:stations,name,{{resourceId}}'),

            Text::make('Broadcast Wave URL', 'broadcast_wave_url')
                ->displayUsing(function () {
                    $src = $this->resource->getAttribute('broadcast_wave_url');

                    if ($src !== null) {
                        $src = Storage::exists($src) ? Storage::url($src) : $src;
                        $src = Str::replaceLast('watch?v=', 'embed/', $src);
                    }

                    return view('nova::common.embed', ['src' => $src])->render();
                })
                ->hideFromIndex()
                ->rules('nullable', 'url')
                ->asHtml(),

            Avatar::make('Logo', 'logo')->disk($this->getDefaultStorage())
                ->disableDownload()
                ->help('Allowed Type: JPG, PNG. | Dimensions: 100x100 - 350x350')
                ->hideFromIndex()
                ->maxWidth(100)
                ->prunable()
                ->path('station/avatar')
                ->rules($this->getImageCreationRules())
                ->squared(),

            Select::make('Type', 'type')
                ->displayUsingLabels()
                ->options(StationInterface::STATION_TYPES)
                ->rules('required')
                ->sortable(),

            Trix::make('Description', 'description')
                ->hideFromIndex()
                ->rules('required'),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(StationInterface::INACTIVE_STATUSES)
                ->loadingWhen([])
                ->sortable(),

            Boolean::make('Status', 'active')
                ->onlyOnForms()
                ->hideWhenCreating(),

            Boolean::make('Featured', 'featured'),

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

            BelongsToMany::make('Programs', 'programs', Program::class),

            BelongsToMany::make('Ads', 'ads', Ad::class),

            BelongsToMany::make('Users', 'users', User::class)
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
            resolve(StationFeaturedFilter::class),
            resolve(StationTypeFilter::class),
            resolve(StationStatusFilter::class),
        ];
    }

    /**
     * @return null|mixed|string
     */
    public function subtitle()
    {
        return $this->resource->getAttribute('description');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return string
     */
    private function getStatus(Model $model): string
    {
        if ($model->getAttribute('deleted_at') !== null) {
            return StationInterface::DELETED;
        }

        return $model->getAttribute('active') ? StationInterface::ACTIVE : StationInterface::INACTIVE;
    }
}
