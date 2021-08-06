<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('app_user_id', false, true);

            $table->string('name');

            $table->boolean('active')
                ->default(0);

            $table->softDeletes();

            $table->timestamps();

            $table->foreign('app_user_id')
                ->on('app_users')
                ->references('id');

            $table->unique(['app_user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlists');
    }
}
