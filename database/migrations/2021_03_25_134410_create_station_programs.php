<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_station', function (Blueprint $table) {
            $table->bigInteger('station_id', false, true);

            $table->bigInteger('program_id', false, true);

            $table->unique(['station_id', 'program_id']);

            $table->foreign('station_id')
                ->on('stations')
                ->references('id');

            $table->foreign('program_id')
                ->on('programs')
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
        Schema::dropIfExists('program_station');
    }
}
