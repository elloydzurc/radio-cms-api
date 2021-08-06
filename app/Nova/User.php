<?php
declare(strict_types=1);

namespace App\Nova;

use App\Models\Interfaces\UserInterface;
use App\Nova\Filters\UserStatusFilter;
use App\Traits\PasswordAwareTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Vyuldashev\NovaPermission\RoleSelect;

/**
 * Class User
 *
 * @package App\Nova
 */
class User extends Resource
{
    use PasswordAwareTrait;

    /**
     * @var string
     */
    public static $group = 'System';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

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
        'id', 'name', 'email',
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
    public static $with = ['stations'];

    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function availableForNavigation(Request $request): bool
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        return $user->hasRole('Admin');
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
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->creationRules('required', 'email', 'max:254', 'unique:users,email')
                ->updateRules('required', 'email', 'max:254', 'unique:users,email,{{resourceId}}')
                ->readonly(function () {
                    return $this->resource->exists;
                }),

            Status::make('Status', function () {
                return $this->getStatus($this->resource);
            })
                ->failedWhen(UserInterface::INACTIVE_STATUSES)
                ->loadingWhen([]),

            Boolean::make('Status', 'active')
                ->default(0)
                ->onlyOnForms()
                ->hideWhenCreating(),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', $this->getPasswordValidation())
                ->updateRules('nullable', $this->getPasswordValidation())
                ->help($this->getPasswordHelperText()),

            RoleSelect::make('Roles')
                ->rules('required'),

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

            BelongsToMany::make('Channels', 'stations', Station::class)
                ->searchable()
                ->withSubtitles()
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
            resolve(UserStatusFilter::class),
        ];
    }

    /**
     * @return null|mixed|string
     */
    public function subtitle()
    {
        return $this->resource->getAttribute('email');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    private function getStatus(Model $model): string
    {
        if ($model->getAttribute('deleted_at') !== null) {
            return UserInterface::DELETED;
        }

        if ($model->getAttribute('email_verified_at') === null || $model->getAttribute('active') === false) {
            return UserInterface::INACTIVE;
        }

        return UserInterface::ACTIVE;
    }
}
