<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('code', 10)
                ->nullable()
                ->unique();

            $table->string('type');

            $table->date('duration_from');

            $table->date('duration_to');

            $table->string('location_type');

            $table->string('location')
                ->nullable();

            $table->string('section');

            $table->json('stations');

            $table->json('contents');

            $table->boolean('active')
                ->default(1);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
