<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\AdInterface;
use App\Models\Interfaces\StationInterface;
use App\Nova\Filters\AdLocationTypeFilter;
use App\Nova\Filters\AdSectionFilter;
use App\Nova\Filters\AdStatusFilter;
use App\Nova\Filters\AdTypeFilter;
use App\Nova\Rules\AdMediaSingleRule;
use App\Nova\Rules\AdMediaSizeRule;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class Ad
 *
 * @package App\Nova
 */
class Ad extends Resource
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
    public static $model = \App\Models\Ad::class;

    /**
     * @var int
     */
    public static $priority = 4;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'code',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        $resource = $request->route('resource');

        if ($resource === 'contents') {
            $query->where('section', '=', AdInterface::CONTENT_SECTION);
        }

        if ($resource === 'programs') {
            $query->where('section', '=', AdInterface::PROGRAM_SECTION);
        }

        if ($resource === 'stations') {
            $query->where('section', '=', AdInterface::CHANNEL_SECTION);
        }

        return $query;
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

            Text::make('Ad Title', 'title')
                ->sortable()
                ->creationRules('required', 'max:255', 'unique:ads,title')
                ->updateRules('required', 'max:255', 'unique:ads,title,{{resourceId}}'),

            Text::make('Code', 'code')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->readonly(),

            Select::make('Type', 'type')
                ->displayUsingLabels()
                ->options(AdInterface::AD_TYPES)
                ->rules('required')
                ->sortable(),

            Images::make('Assets', 'assets')
                ->customPropertiesFields([
                    Text::make('URL', 'url')
                ])
                ->hideFromIndex()
                ->rules(new AdMediaSizeRule($request, $this->resource->exists))
                ->singleMediaRules(AdMediaSingleRule::ruleGetter($request, $this->resource->exists)),

            NovaDependencyContainer::make([
                Heading::make('<small><i>
                    Banner Dimensions - Width: 660px Height: 107px. 
                    Hover the image to set the URL or remove the image
                </i><small>')->asHtml()
            ])
                ->dependsOn('type', AdInterface::BANNER_AD)
                ->onlyOnForms(),

            NovaDependencyContainer::make([
                Heading::make('<small><i>
                    Popup Dimensions - Width: 600px Height: 900px. 
                    Hover the image to set the URL or remove the image
                </i></small>')->asHtml()
            ])
                ->dependsOn('type', AdInterface::POPUP_AD)
                ->onlyOnForms(),

            NovaDependencyContainer::make([
                Heading::make('<small><i>
                    Slider Dimensions - Width: 660px Height: 199px. 
                    Hover the image to set the URL or remove the image
                </i><small>')->asHtml()
            ])
                ->dependsOn('type', AdInterface::SLIDER_AD)
                ->onlyOnForms(),

            Date::make('Duration From', 'duration_from')
                ->rules('required', 'before_or_equal:duration_to'),

            Date::make('Duration To', 'duration_to')
                ->rules('required', 'after_or_equal:duration_from'),

            Select::make('Location Type', 'location_type')
                ->displayUsingLabels()
                ->options(AdInterface::AD_LOCATIONS)
                ->rules('required')
                ->sortable(),

            NovaDependencyContainer::make([
                Text::make('Location', 'location')
                    ->rules('required')
            ])
                ->dependsOn('location_type', AdInterface::LOCAL_AD)
                ->hideFromIndex(),

            NovaDependencyContainer::make([
                Select::make('Section', 'section')
                    ->displayUsingLabels()
                    ->options(AdInterface::SLIDER_SECTIONS)
                    ->rules('required')
                    ->sortable(),
            ])
                ->dependsOn('type', AdInterface::SLIDER_AD),

            /*Select::make('Options')->options(function () {
                return [
                    ''
                ];
            }),*/

            NovaDependencyContainer::make([
                Select::make('Section', 'section')
                    ->displayUsingLabels()
                    ->options(AdInterface::BANNER_SECTIONS)
                    ->rules('required')
                    ->sortable(),
            ])
                ->dependsOn('type', AdInterface::BANNER_AD),

            NovaDependencyContainer::make([
                Select::make('Section', 'section')
                    ->displayUsingLabels()
                    ->options(AdInterface::POPUP_SECTIONS)
                    ->rules('required')
                    ->sortable(),
            ])
                ->dependsOn('type', AdInterface::POPUP_AD),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(StationInterface::INACTIVE_STATUSES)
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
            app(AdStatusFilter::class),
            app(AdTypeFilter::class),
            app(AdLocationTypeFilter::class),
            app(AdSectionFilter::class),
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
