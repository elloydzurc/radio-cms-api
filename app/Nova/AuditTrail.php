<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\AuditTrailInterface;
use App\Nova\Filters\AuditTrailActionFilter;
use App\Nova\Filters\AuditTrailTargetFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Titasgailius\SearchRelations\SearchesRelations;

/**
 * Class AuditTrail
 *
 * @package App\Nova
 */
class AuditTrail extends Resource
{
    use SearchesRelations;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AuditTrail::class;

    /**
     * @var int
     */
    public static $priority = 1;

    /**
     * Model relationship
     *
     * @var array $with
     */
    public static $with = ['user'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'target' => ['name'],
        'user' => ['name']
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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

            BelongsTo::make('User', 'user')
                ->viewable(false),

            Text::make('Action', 'name'),

            MorphTo::make('Target')
                ->types(AuditTrailInterface::TARGET_TYPES)
                ->viewable(false),

            KeyValue::make('Original', 'original')
                ->onlyOnDetail()
                ->rules('json'),

            KeyValue::make('Changes', 'changes')
                ->onlyOnDetail()
                ->rules('json'),

            DateTime::make('Action Date', 'created_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->sortable(),
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
            resolve(AuditTrailActionFilter::class),
            resolve(AuditTrailTargetFilter::class),
        ];
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        return $query->where('exception', '=', '')
            ->whereIn('name', AuditTrailInterface::ACTION_TYPES);
    }
}
