<?php

use App\Models\Content;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateActionEventsRenameModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('action_events')
            ->where('actionable_type', '=', 'App\Models\StationContent')
            ->update(['actionable_type' => Content::class]);

        DB::table('action_events')
            ->where('target_type', '=', 'App\Models\StationContent')
            ->update(['target_type' => Content::class]);

        DB::table('action_events')
            ->where('model_type', '=', 'App\Models\StationContent')
            ->update(['model_type' => Content::class]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Do nothing
    }
}
