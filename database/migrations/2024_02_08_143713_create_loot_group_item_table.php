<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLootGroupItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loot_group_item', function (Blueprint $table) {
            $table->bigIncrements('loot_group_item_id');
            $table->unsignedBigInteger('loot_group_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('loot_group_item_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loot_group_item');
    }
}
