<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_contents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('station_id', false, true);

            $table->string('name')
                ->unique();

            $table->longText('description');

            $table->string('content_url');

            $table->string('type');

            $table->string('thumbnail')
                ->nullable();

            $table->string('age_restriction');

            $table->dateTime('broadcast_date');

            $table->boolean('active')
                ->default(1);

            $table->softDeletes();

            $table->timestamps();

            $table->foreign('station_id')
                ->on('stations')
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
        Schema::dropIfExists('station_contents');
    }
}
