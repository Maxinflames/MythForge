<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartyInventoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_inventory_item', function (Blueprint $table) {
            $table->bigIncrements('party_inventory_item_id');
            $table->unsignedBigInteger('party_inventory_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('party_inventory_item_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party_inventory_item');
    }
}
