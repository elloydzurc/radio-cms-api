<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\ContentInterface;
use App\Models\Interfaces\RoleInterface;
use App\Models\Interfaces\StationInterface;
use App\Nova\Actions\ExportContents;
use App\Nova\Filters\ContentAgeRestrictionFilter;
use App\Nova\Filters\ContentFeaturedFilter;
use App\Nova\Filters\ContentStatusFilter;
use App\Nova\Filters\ContentTypeFilter;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;
use Titasgailius\SearchRelations\SearchesRelations;

/**
 * Class Content
 *
 * @package App\Nova
 */
class Content extends Resource
{
    use SearchesRelations;

    /**
     * @var string
     */
    public static $group = 'Content Management';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Content::class;

    /**
     * @var int
     */
    public static $priority = 3;

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
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'program' => ['name']
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
    public static $with = ['program', 'ads'];

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
        /** @var \App\Models\User $user */
        $user = $request->user();
        $contentType = [];

        if ($user->can('Read Content On Demand')) {
            $contentType[] = ContentInterface::TYPE_ON_DEMAND;
        }

        if ($user->can('Read Content Live Stream')) {
            $contentType[] = ContentInterface::TYPE_LIVE;
        }

        if ($user->hasRole(RoleInterface::ADMIN_ROLE) === false) {
            $query->whereIn('station_id', $user->stations()->pluck('id')->toArray());
        }

        return $query->whereIn('type', $contentType);
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return 'Episodes';
    }

    /**
     * @return string
     */
    public static function singularLabel(): string
    {
        return 'Episode';
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            (new ExportContents())
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

            Text::make('Episode Title', 'name')
                ->sortable()
                ->creationRules('required', 'max:255', 'unique:contents,name')
                ->updateRules('required', 'unique:contents,name,{{resourceId}}'),

            BelongsTo::make('Program', 'program', Program::class)
                ->rules('required')
                ->sortable()
                ->viewable(false)
                ->withoutTrashed(),

            Textarea::make('Description', 'description')
                ->hideFromIndex()
                ->rows(3)
                ->rules('required'),

            Select::make('Episode Format', 'format')
                ->displayUsingLabels()
                ->options(ContentInterface::CONTENT_FORMATS)
                ->rules('required'),

            NovaDependencyContainer::make([
                Text::make('Episode', 'content_url')
                    ->resolveUsing(function () {
                        $content = $this->resource->getAttribute('content_url');
                        return Storage::exists($content) ? null : $content;
                    })
            ])
                ->dependsOn('format', ContentInterface::FORMAT_YOUTUBE)
                ->dependsOn('format', ContentInterface::FORMAT_PODCAST)
                ->onlyOnForms(),

            NovaDependencyContainer::make([
                File::make('Episode', 'content_file')->disk($this->getDefaultStorage())
                    ->disableDownload()
                    ->deletable(false)
                    ->help('Allowed video/audio type: .wav, .mp3, .aac, .wma, .avi, .mp4, .wmv, .flv, .mov | Max Size: 1GB')
                    ->onlyOnForms()
                    ->path('station/content/media')
                    ->prunable()
                    ->resolveUsing(function () {
                        $content = $this->resource->getAttribute('content_url');
                        return Storage::exists($content) ? Storage::url($content) : null;
                    })
                    ->store(function (Request $request) {
                        $contentFile = $request->file('content_file');

                        if ($contentFile === null) {
                            return [];
                        }

                        return [
                            'content_url' => $contentFile->store(
                                'station/content/media',
                                $this->getDefaultStorage()
                            )
                        ];
                    })
            ])
                ->dependsOn('format', ContentInterface::FORMAT_AUDIO)
                ->dependsOn('format', ContentInterface::FORMAT_VIDEO)
                ->onlyOnForms(),

            Text::make('Episode', function () {
                $src = $this->resource->getAttribute('content_url');

                if ($src !== null) {
                    $src = Storage::exists($src) ? Storage::url($src) : $src;
                    $src = Str::replaceLast('watch?v=', 'embed/', $src);
                }

                return view('nova::common.embed', ['src' => $src])->render();
            })
                ->onlyOnDetail()
                ->asHtml(),

            Avatar::make('Thumbnail', 'thumbnail')->disk($this->getDefaultStorage())
                ->disableDownload()
                ->help('Allowed Type: JPG, PNG. | Dimensions: 100x100 - 350x350')
                ->hideFromIndex()
                ->maxWidth(100)
                ->path('station/content/avatar')
                ->prunable()
                ->rules($this->getImageCreationRules())
                ->squared(),

            NovaDependencyContainer::make([
                Select::make('Type', 'type')
                    ->displayUsingLabels()
                    ->options(ContentInterface::CONTENT_TYPES)
                    ->rules('required')
                    ->sortable(),
            ])
                ->dependsOnNot('format', ContentInterface::FORMAT_AUDIO)
                ->onlyOnForms(),

            Select::make('Type', 'type')
                ->displayUsingLabels()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->options(ContentInterface::CONTENT_TYPES)
                ->showOnDetail()
                ->showOnIndex(),

            Select::make('Age Restriction', 'age_restriction')
                ->displayUsingLabels()
                ->options($this->getAgeRestrictionOptions())
                ->rules('required')
                ->sortable(),

            Tags::make('Tags')
                ->hideFromIndex()
                ->limitSuggestions(10)
                ->rules('required'),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(ContentInterface::INACTIVE_STATUSES)
                ->loadingWhen([])
                ->sortable(),

            Boolean::make('Status', 'active')
                ->onlyOnForms()
                ->hideWhenCreating(),

            Boolean::make('Featured', 'featured'),

            DateTime::make('Broadcast Date', 'broadcast_date')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->rules('required', 'date')
                ->sortable(),

            DateTime::make('Deleted At', 'deleted_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->onlyOnDetail(),

            DateTime::make('Last Update', 'updated_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->onlyOnDetail(),

            DateTime::make('Created At', 'created_at')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->onlyOnDetail(),

            BelongsToMany::make('Ads', 'ads', Ad::class),
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
            resolve(ContentAgeRestrictionFilter::class),
            resolve(ContentFeaturedFilter::class),
            resolve(ContentStatusFilter::class),
            resolve(ContentTypeFilter::class)
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
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Validation\Validator $validator
     */
    protected static function afterValidation(NovaRequest $request, $validator): void
    {
        $context = $request->toArray();
        $linkFormat = \implode(',', ContentInterface::LINK_FORMAT);

        $rules = [
            'content_url' => ['required_if:format,' . $linkFormat, 'url'],
        ];

        if ($context['editMode'] === 'create') {
            $config = config('cms.content');
            $fileFormat = \implode(',', ContentInterface::FILE_FORMAT);

            $rules['content_file'] = [
                'max:' . $config['max_upload_size'],
                'mimes:' . $config['allowed_file_types'],
                'required_if:format,' . $fileFormat,
            ];
        }

        $request->validate($rules);
    }

    /**
     * @return array
     */
    private function getAgeRestrictionOptions(): array
    {
        $options = [];
        $ageRestrictions = config('cms.age_restrictions');

        foreach ($ageRestrictions as $ageRestriction) {
            $options[$ageRestriction['code']] = $ageRestriction['name'];
        }

        return $options;
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
