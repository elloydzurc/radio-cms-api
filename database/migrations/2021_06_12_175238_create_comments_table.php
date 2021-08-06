<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('app_user_id', false, true);

            $table->bigInteger('content_id', false, true);

            $table->longText('comment');

            $table->boolean('active')
                ->default(0);

            $table->softDeletes();

            $table->timestamps();

            $table->foreign('app_user_id')
                ->on('app_users')
                ->references('id');

            $table->foreign('content_id')
                ->on('contents')
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
        Schema::dropIfExists('comments');
    }
}
