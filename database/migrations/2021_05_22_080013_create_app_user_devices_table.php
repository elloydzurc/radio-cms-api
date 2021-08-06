<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_devices', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('app_user_id', false, true);

            $table->string('device_id');

            $table->unique(['app_user_id', 'device_id']);

            $table->foreign('app_user_id')
                ->on('app_users')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user_devices');
    }
}
