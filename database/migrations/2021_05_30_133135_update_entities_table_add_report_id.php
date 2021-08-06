<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntitiesTableAddReportId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_users', static function (Blueprint $table) {
            $table->bigInteger('report_id', false, true)
                ->default(1);

            $table->foreign('report_id')
                ->on('reports')
                ->references('id');
        });

        Schema::table('programs', static function (Blueprint $table) {
            $table->bigInteger('report_id', false, true)
                ->default(1);

            $table->foreign('report_id')
                ->on('reports')
                ->references('id');
        });

        Schema::table('stations', static function (Blueprint $table) {
            $table->bigInteger('report_id', false, true)
                ->default(1);

            $table->foreign('report_id')
                ->on('reports')
                ->references('id');
        });

        Schema::table('contents', static function (Blueprint $table) {
            $table->bigInteger('report_id', false, true)
                ->default(1);

            $table->foreign('report_id')
                ->on('reports')
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
        Schema::table('app_users', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('report_id');
        });

        Schema::table('programs', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('report_id');
        });

        Schema::table('stations', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('report_id');
        });

        Schema::table('contents', static function (Blueprint $table) {
            $table->dropConstrainedForeignId('report_id');
        });
    }
}
