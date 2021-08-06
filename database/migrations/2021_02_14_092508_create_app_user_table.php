<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->string('first_name');

            $table->string('last_name');

            $table->string('email')
                ->unique();

            $table->date('date_of_birth');

            $table->string('gender', 6);

            $table->string('password');

            $table->string('avatar')
                ->nullable();

            $table->string('city');

            $table->string('region');

            $table->string('provider');

            $table->rememberToken();

            $table->boolean('active')
                ->default(0);

            $table->dateTime('email_verified_at')
                ->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users');
    }
}
