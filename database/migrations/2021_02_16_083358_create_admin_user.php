<?php
declare(strict_types=1);

use App\Models\Interfaces\RoleInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create admin user and role.
        Artisan::call('permission:sync');

        $adminEmail = 'info@radyonow.ph';
        $dateTime = Carbon::now();

        $identifier = ['email'];
        $columns = [
            'name',
            'first_name',
            'last_name',
            'email_verified_at',
            'password',
            'active',
            'updated_at',
            'created_at'
        ];

        DB::table('users')->upsert([
            [
                'email' => $adminEmail,
                'name' => 'Radyo Now',
                'first_name' => 'Radyo',
                'last_name' => 'Now',
                'email_verified_at' => $dateTime,
                'password' => Hash::make('admin'),
                'active' => 1,
                'updated_at' => $dateTime,
                'created_at' => $dateTime
            ]
        ], $identifier, $columns);

        $adminId = (DB::table('users')->where('email', $adminEmail)
            ->select('id')
            ->first())->id;

        DB::table('roles')->upsert([
            [
                'name' => RoleInterface::ADMIN_ROLE,
                'guard_name' => 'web',
                'updated_at' => $dateTime,
                'created_at' => $dateTime
            ]
        ], ['name'], ['guard_name', 'updated_at', 'created_at']);

        $roleId = (DB::table('roles')->where('name', 'Admin')
            ->select('id')
            ->first())->id;

        $permissions = DB::table('permissions')
            ->select('id')
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->upsert([
                ['permission_id' => $permission->id, 'role_id' => $roleId]
            ], ['permission_id', 'role_id'], ['permission_id', 'role_id']);
        }

        DB::table('model_has_roles')->upsert([
            ['role_id' => $roleId, 'model_type' => \App\Models\User::class, 'model_id' => $adminId]
        ], ['role_id', 'model_type', 'model_id'], ['role_id', 'model_type', 'model_id']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Do nothing
    }
}
