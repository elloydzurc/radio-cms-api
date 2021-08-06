<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_program', function (Blueprint $table) {
            $table->bigInteger('program_id', false, true);

            $table->bigInteger('ad_id', false, true);

            $table->unique(['program_id', 'ad_id']);

            $table->foreign('program_id')
                ->on('programs')
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
        Schema::dropIfExists('ad_program');
    }
}
