<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('time_of_prize1')->nullable();
            $table->string('time_of_prize2')->nullable();
            $table->string('time_of_prize3')->nullable();
            $table->string('cost_of_ticket')->nullable();
            $table->string('min_of_btc')->nullable();
            $table->boolean('is_ready1')->default(0);
            $table->boolean('is_ready2')->default(0);
            $table->boolean('is_ready3')->default(0);
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
        Schema::dropIfExists('settings');
    }
}
