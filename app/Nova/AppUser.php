<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\AppUserInterface;
use App\Nova\Actions\ExportAppUsers;
use App\Nova\Filters\AppUserProviderFilter;
use App\Nova\Filters\AppUserStatusFilter;
use App\Traits\PasswordAwareTrait;
use App\Traits\StorageAwareTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

/**
 * Class AppUser
 *
 * @package App\Nova
 */
class AppUser extends Resource
{
    use PasswordAwareTrait, StorageAwareTrait;

    /**
     * @var string
     */
    public static $group = 'System';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AppUser::class;

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
        'id', 'name', 'email',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request): array
    {
        return [
            (new ExportAppUsers())
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

            Text::make('First Name')
                ->rules('required', 'max:255')
                ->sortable(),

            Text::make('Last Name')
                ->rules('required', 'max:255')
                ->sortable(),

            Avatar::make('Avatar', 'avatar')->disk($this->getStorageDefault())
                ->disableDownload()
                ->hideFromIndex()
                ->maxWidth(100)
                ->path('app_users/avatar')
                ->preview(function ($value, $disk) {
                    return Storage::disk($disk)->exists($value) ? Storage::disk($disk)->url($value) : $value;
                })
                ->prunable()
                ->squared(),

            Text::make('Email')
                ->sortable()
                ->creationRules('required', 'email', 'max:254', 'unique:app_users,email')
                ->updateRules('required', 'email', 'max:254', 'unique:app_users,email,{{resourceId}}')
                ->readonly(function () {
                    return $this->resource->exists;
                }),

            Password::make('Password')
                ->canSee(function (Request $request) {
                    return $request->user()->can('Create App User');
                })
                ->creationRules('required', $this->getPasswordValidation())
                ->onlyOnForms()
                ->updateRules('nullable', $this->getPasswordValidation())
                ->help($this->getPasswordHelperText()),

            Date::make('Date of Birth', 'date_of_birth')
                ->format(self::DEFAULT_DATE_FORMAT)
                ->hideFromIndex()
                ->rules('required', 'date')
                ->sortable(),

            Select::make('Gender', 'gender')
                ->displayUsingLabels()
                ->hideFromIndex()
                ->options(AppUserInterface::GENDERS)
                ->rules('required')
                ->sortable(),

            Text::make('City', 'city')
                ->hideFromIndex()
                ->rules('required')
                ->sortable(),

            Text::make('Region', 'region')
                ->hideFromIndex()
                ->rules('required')
                ->sortable(),

            Select::make('Provider', 'provider')
                ->default(function () {
                    return AppUserInterface::PROVIDER_APP;
                })
                ->displayUsingLabels()
                ->options(AppUserInterface::PROVIDERS)
                ->sortable()
                ->withMeta([
                    'readonly' => true
                ]),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(AppUserInterface::INACTIVE_STATUSES)
                ->loadingWhen([]),

            Boolean::make('Status', 'active')
                ->default(0)
                ->hideWhenCreating()
                ->onlyOnForms(),

            DateTime::make('Last Login', 'last_login')
                ->format(self::DEFAULT_DATETIME_FORMAT)
                ->hideWhenUpdating()
                ->hideWhenCreating()
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
            resolve(AppUserStatusFilter::class),
            resolve(AppUserProviderFilter::class)
        ];
    }

    /**
     * @return null|string
     */
    public function subtitle(): ?string
    {
        return $this->resource->getAttribute('email');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return string
     */
    private function getStatus(Model $model): string
    {
        if ($model->getAttribute('deleted_at') !== null) {
            return AppUserInterface::DELETED;
        }

        if ($model->getAttribute('email_verified_at') === null || $model->getAttribute('active') === false) {
            return AppUserInterface::INACTIVE;
        }

        return AppUserInterface::ACTIVE;
    }
}
