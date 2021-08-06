<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePushNotificationsAddContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('push_notifications', static function (Blueprint $table) {
            $table->bigInteger('content_id', false, true)
                ->after('description')
                ->nullable();

            $table->dropColumn('content');

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
        Schema::table('push_notifications', static function (Blueprint $table) {
            $table->longText('content');

            $table->dropConstrainedForeignId('content_id');
        });
    }
}
