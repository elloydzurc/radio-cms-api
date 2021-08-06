<?php
declare(strict_types=1);

namespace App\Nova;

use App\Traits\ImageAwareTrait;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

/**
 * Class Resource
 *
 * @package App\Nova
 */
abstract class Resource extends NovaResource
{
    use ImageAwareTrait;

    /**
     * @var string
     */
    public const DEFAULT_DATETIME_FORMAT = 'DD MMM YYYY h:mm A';

    /**
     * @var string
     */
    public const DEFAULT_DATE_FORMAT = 'DD MMM YYYY';

    /**
     * @var bool $globallySearchable
     */
    public static $globallySearchable = false;

    /**
     * Default items per page if loaded via relationship model
     *
     * @var int $perPageViaRelationship
     */
    public static $perPageViaRelationship = 10;

    /**
     * @var bool $preventFormAbandonment
     */
    public static $preventFormAbandonment = true;

    /**
     * The number of results to display when searching for relatable resources without Scout.
     *
     * @var int|null
     */
    public static $relatableSearchResults = 500;

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

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
        return parent::relatableQuery($request, $query);
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * @return bool
     */
    public static function softDeletes()
    {
        parent::softDeletes();

        return Gate::check('delete', [static::newModel()]);
    }
}
