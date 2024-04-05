<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerInventoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_inventory_item', function (Blueprint $table) {
            $table->bigIncrements('player_inventory_item_id');
            $table->unsignedBigInteger('player_inventory_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('player_inventory_item_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('player_inventory_item');
    }
}
