<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_station', function (Blueprint $table) {
            $table->bigInteger('station_id', false, true);

            $table->bigInteger('ad_id', false, true);

            $table->unique(['station_id', 'ad_id']);

            $table->foreign('station_id')
                ->on('stations')
                ->references('id');

            $table->foreign('ad_id')
                ->on('ads')
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
        Schema::dropIfExists('ad_station');
    }
}
