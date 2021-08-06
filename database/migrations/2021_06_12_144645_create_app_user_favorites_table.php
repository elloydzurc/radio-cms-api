<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_favorites', function (Blueprint $table) {
            $table->bigInteger('app_user_id', false, true);

            $table->bigInteger('content_id', false, true);

            $table->timestamp('date_added');

            $table->foreign('app_user_id')
                ->on('app_users')
                ->references('id');

            $table->foreign('content_id')
                ->on('contents')
                ->references('id');

            $table->unique(['app_user_id', 'content_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user_favorites');
    }
}
