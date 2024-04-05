<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLootTableItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loot_table_item', function (Blueprint $table) {
            $table->bigIncrements('loot_table_item_id');
            $table->unsignedBigInteger('loot_table_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('loot_table_item_dice_count');
            $table->integer('loot_table_item_roll');
            $table->integer('loot_table_item_count');
            $table->integer('loot_table_item_weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loot_table_item');
    }
}
