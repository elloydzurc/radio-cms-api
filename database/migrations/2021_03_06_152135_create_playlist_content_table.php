<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_content', function (Blueprint $table) {
            $table->bigInteger('playlist_id', false, true);

            $table->bigInteger('content_id', false, true);

            $table->unique(['playlist_id', 'content_id']);

            $table->foreign('playlist_id')
                ->on('playlists')
                ->references('id');

            $table->foreign('content_id')
                ->on('station_contents')
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
        Schema::dropIfExists('playlist_content');
    }
}
