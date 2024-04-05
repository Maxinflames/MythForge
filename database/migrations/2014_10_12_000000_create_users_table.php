<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('user_name', 50)->unique();
            $table->string('user_first_name', 50);
            $table->string('user_last_name', 50);
            $table->string('user_description', 255);
            $table->string('user_email_address', 255)->unique();
            $table->string('user_profile_picture')->default('user.png');
            $table->string('user_password', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
