<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_message', function (Blueprint $table) {
            $table->bigIncrements('campaign_message_id');
            $table->unsignedBigInteger('campaign_chat_id');
            $table->unsignedBigInteger('player_id')->nullable();
            $table->string('campaign_message_content', 75);
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
        Schema::dropIfExists('campaign_message');
    }
}
