<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStationContentsAddProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('station_contents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('station_id');

            $table->bigInteger('program_id', false, true)
                ->after('id')
                ->nullable();

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
        Schema::table('station_contents', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_id');

            $table->bigInteger('station_id', false, true)
                ->after('id')
                ->nullable();

            $table->foreign('station_id')
                ->on('programs')
                ->references('id');
        });
    }
}
