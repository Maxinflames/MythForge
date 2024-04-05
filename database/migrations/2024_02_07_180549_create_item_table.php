<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('game_type_id');
            $table->string('item_title', 75);
            $table->text('item_description');
            $table->boolean('item_status'); // Whether the item is available publically or not
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
