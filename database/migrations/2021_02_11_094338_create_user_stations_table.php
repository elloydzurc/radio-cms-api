<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_stations', function (Blueprint $table) {
            $table->bigInteger('user_id', false, true);

            $table->bigInteger('station_id', false, true);

            $table->foreign('user_id')
                ->on('users')
                ->references('id');

            $table->foreign('station_id')
                ->on('stations')
                ->references('id');

            $table->unique(['user_id', 'station_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_stations');
    }
}
