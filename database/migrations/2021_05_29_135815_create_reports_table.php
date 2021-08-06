<?php
declare(strict_types=1);

use App\Models\Interfaces\ReportInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', static function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
        });

        DB::table('reports')->insert([
            'title' => 'Reports',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
