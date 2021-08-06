<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_content', function (Blueprint $table) {
            $table->bigInteger('content_id', false, true);

            $table->bigInteger('ad_id', false, true);

            $table->unique(['content_id', 'ad_id']);

            $table->foreign('content_id')
                ->on('contents')
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
        Schema::dropIfExists('ad_content');
    }
}
