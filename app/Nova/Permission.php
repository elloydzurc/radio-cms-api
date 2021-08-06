<?php
declare(strict_types=1);

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Spatie\Permission\PermissionRegistrar;
use Vyuldashev\NovaPermission\RoleBooleanGroup;

/**
 * Class Station
 *
 * @package App\Nova
 */
class Permission extends Resource
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
    public static $model = \App\Models\Permission::class;

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
        'name',
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Determine if this resource is available for navigation.
     *
     * @param Request $request
     *
     * @return bool
     */
    public static function availableForNavigation(Request $request): bool
    {
        return Gate::allows('viewAny', app(PermissionRegistrar::class)->getPermissionClass());
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('nova-permission-tool::permissions.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.permissions'))
                ->updateRules('unique:'.config('permission.table_names.permissions').',name,{{resourceId}}'),

            Text::make(__('nova-permission-tool::permissions.display_name'), function () {
                return __('nova-permission-tool::permissions.display_names.'.$this->resource->getAttribute('name'));
            })->canSee(function () {
                return is_array(__('nova-permission-tool::permissions.display_names'));
            }),

            Hidden::make(__('nova-permission-tool::permissions.guard_name'), 'guard_name')
                ->withMeta([
                    'value' => 'web',
                    'type' => 'hidden'
                ]),

            RoleBooleanGroup::make(__('nova-permission-tool::permissions.roles'), 'roles')
                ->hideFromIndex(),

            MorphToMany::make('Roles', 'roles', Role::class),

            DateTime::make(__('nova-permission-tool::permissions.created_at'), 'created_at')
                ->exceptOnForms(),

            DateTime::make(__('nova-permission-tool::permissions.updated_at'), 'updated_at')
                ->exceptOnForms(),
        ];
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return __('nova-permission-tool::resources.Permissions');
    }

    /**
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('nova-permission-tool::resources.Permission');
    }

    /**
     * @return mixed
     */
    public static function getModel()
    {
        return app(PermissionRegistrar::class)->getPermissionClass();
    }
}
