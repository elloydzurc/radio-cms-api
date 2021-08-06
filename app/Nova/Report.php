<?php
declare(strict_types=1);

namespace App\Nova;

use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;

/**
 * Class Report
 *
 * @package App\Nova
 */
class Report extends Resource
{
    /**
     * @var string
     */
    public static $group = 'System';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Report::class;

    /**
     * @var int
     */
    public static $priority = 5;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Model relationship
     *
     * @var array $with
     */
    public static $with = [
        'appUsers',
        'programs',
        'stations',
        'contents',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return  [
            Tabs::make('Relations', [
                HasMany::make('App Users', 'appUsers', AppUser::class)
                    ->canSee(function () use ($request) {
                        return $request->user()->can('Download App Users');
                    }),

                HasMany::make('Programs', 'programs', Program::class)
                    ->canSee(function () use ($request) {
                        return $request->user()->can('Download Programs');
                    }),

                HasMany::make('Channels', 'stations', Station::class)
                    ->canSee(function () use ($request) {
                        return $request->user()->can('Download Channels');
                    }),

                HasMany::make('Episodes', 'contents', Content::class)
                    ->canSee(function () use ($request) {
                        return $request->user()->can('Download Episodes');
                    }),
            ]),
        ];
    }
}
