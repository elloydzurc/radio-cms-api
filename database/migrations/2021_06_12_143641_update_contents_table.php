<?php
declare(strict_types=1);

use App\Models\Interfaces\ContentInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('contents')
            ->where('type','=', 'stream')
            ->update(['type' => ContentInterface::TYPE_LIVE]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('contents')
            ->where('type','=', ContentInterface::TYPE_LIVE)
            ->update(['type' => 'stream']);
    }
}
