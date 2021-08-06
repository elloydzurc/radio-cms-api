<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAppUsersTableAddUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->string('password')
                ->nullable()
                ->change();

            $table->date('date_of_birth')
                ->nullable()
                ->change();

            $table->string('gender')
                ->nullable()
                ->change();

            $table->string('city')
                ->nullable()
                ->change();

            $table->string('region')
                ->nullable()
                ->change();

            $table->string('provider_id')
                ->after('provider')
                ->nullable();

            $table->dropUnique(['email']);

            $table->unique(['email', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->string('password')
                ->change();

            $table->dropColumn('provider_id');

            $table->dropUnique(['email', 'provider']);

            $table->unique(['email']);
        });
    }
}
