<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\ProgramInterface;
use App\Nova\Actions\ExportPrograms;
use App\Nova\Filters\ProgramStatusFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

/**
 * Class Program
 *
 * @package App\Nova
 */
class Program extends Resource
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
    public static $model = \App\Models\Program::class;

    /**
     * @var int
     */
    public static $priority = 2;

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
        'contents',
        'stations',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            (new ExportPrograms())
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
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Program Name', 'name')
                ->sortable()
                ->creationRules('required', 'max:255', 'unique:programs,name')
                ->updateRules('required', 'max:255', 'unique:programs,name,{{resourceId}}'),

            Textarea::make('Description', 'description')
                ->hideFromIndex()
                ->rows(3)
                ->rules('required'),

            Avatar::make('Thumbnail', 'thumbnail')->disk($this->getDefaultStorage())
                ->disableDownload()
                ->help('Allowed Type: JPG, PNG. | Dimensions: 100x100 - 350x350')
                ->hideFromIndex()
                ->maxWidth(100)
                ->prunable()
                ->path('program/thumbnail')
                ->rules($this->getImageCreationRules())
                ->squared(),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(ProgramInterface::INACTIVE_STATUSES)
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

            HasMany::make('Episodes', 'contents', Content::class),

            BelongsToMany::make('Channels', 'stations', Station::class),

            BelongsToMany::make('Ads', 'ads', Ad::class),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function filters(Request $request): array
    {
        return [
            app(ProgramStatusFilter::class)
        ];
    }

    /**
     * @return null|string
     */
    public function subtitle(): ?string
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
            return ProgramInterface::DELETED;
        }

        return $model->getAttribute('active') ? ProgramInterface::ACTIVE : ProgramInterface::INACTIVE;
    }
}
