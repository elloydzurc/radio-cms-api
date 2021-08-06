<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStationContentsAddFeatured extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('station_contents', function (Blueprint $table) {
            $table->string('format')
                ->after('content_url')
                ->nullable();

            $table->boolean('featured')
                ->after('active')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('station_contents', function (Blueprint $table) {
            $table->dropColumn(['format', 'featured']);
        });
    }
}
