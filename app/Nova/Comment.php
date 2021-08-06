<?php
declare(strict_types=1);

namespace App\Nova;

use App\Nova\Filters\CommentStatusFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

/**
 * Class Comment
 *
 * @package App\Nova
 */
class Comment extends Resource
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
    public static $model = \App\Models\Comment::class;

    /**
     * @var int
     */
    public static $priority = 6;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'comment',
    ];

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
    public static $with = ['appUser', 'content'];

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

            Text::make('Comment', 'comment')
                ->onlyOnIndex()
                ->resolveUsing(function ($comment) {
                    if (\strlen($comment) > 20) {
                        return \substr($comment, 0, 20) . '...';
                    }

                    return $comment;
                }),

            BelongsTo::make('Episode', 'content', Content::class)
                ->readonly()
                ->viewable(false),

            BelongsTo::make('App User', 'appUser', AppUser::class)
                ->readonly()
                ->viewable(false),

            Textarea::make('Comment', 'comment')
                ->alwaysShow()
                ->readonly(),

            Boolean::make('Approved', 'active'),

            DateTime::make('Last Update', 'updated_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            DateTime::make('Created At', 'created_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->hideWhenCreating()
                ->hideWhenUpdating()
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
            app(CommentStatusFilter::class),
        ];
    }
}
