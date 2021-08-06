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
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;
use Vyuldashev\NovaPermission\PermissionBooleanGroup;

/**
 * Class Role
 *
 * @package App\Nova
 */
class Role extends Resource
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
    public static $model = \App\Models\Role::class;

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
        return Gate::allows('viewAny', app(PermissionRegistrar::class)->getRoleClass());
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        $userResource = Nova::resourceForModel(getModelForGuard($this->resource->getAttribute('guard_name')));

        return [
            ID::make()->sortable(),

            Text::make(__('nova-permission-tool::roles.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.roles'))
                ->updateRules('unique:'.config('permission.table_names.roles').',name,{{resourceId}}'),

            Hidden::make(__('nova-permission-tool::roles.guard_name'), 'guard_name')
                ->withMeta([
                    'value' => 'web',
                    'type' => 'hidden'
                ]),

            PermissionBooleanGroup::make(__('nova-permission-tool::roles.permissions'), 'permissions')
                ->hideFromIndex(),

            MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->singularLabel($userResource::singularLabel()),

            DateTime::make(__('nova-permission-tool::roles.created_at'), 'created_at')
                ->exceptOnForms(),

            DateTime::make(__('nova-permission-tool::roles.updated_at'), 'updated_at')
                ->exceptOnForms(),
        ];
    }

    /**
     * @return string
     */
    public static function label(): string
    {
        return __('nova-permission-tool::resources.Roles');
    }

    /**
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('nova-permission-tool::resources.Role');
    }

    /**
     * @return mixed
     */
    public static function getModel()
    {
        return app(PermissionRegistrar::class)->getRoleClass();
    }
}
