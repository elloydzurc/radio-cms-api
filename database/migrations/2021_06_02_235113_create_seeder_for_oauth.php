<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSeederForOauth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('oauth_access_tokens')->truncate();
        DB::table('oauth_auth_codes')->truncate();
        DB::table('oauth_clients')->truncate();
        DB::table('oauth_personal_access_clients')->truncate();
        DB::table('oauth_refresh_tokens')->truncate();

        // OAuth Client
        $oauthClient = DB::table('oauth_clients')->insertGetId([
            'name' => 'RTV Now Personal Access Client',
            'secret' => 'Du7vgJOVVtgoGFB0R0YhDoSWjklQdDNJxrNShalZ',
            'redirect' => 'http://localhost',
            'personal_access_client' => 1,
            'password_client' => 0,
            'provider' => 'app_users',
            'revoked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // OAuth Personal Access Client
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $oauthClient,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No body needed
    }
}
