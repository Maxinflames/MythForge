<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_post', function (Blueprint $table) {
            $table->bigIncrements('campaign_post_id');
            $table->unsignedBigInteger('campaign_id');
            $table->string('campaign_post_title', 75);
            $table->longText('campaign_post_content');
            $table->boolean('campaign_post_status');
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
        Schema::dropIfExists('campaign_post');
    }
}
