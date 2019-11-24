<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->double('cost_of_ticket')->nullable();
            $table->string('description')->nullable();
            $table->time('time_of_prize1')->nullable();
            $table->time('time_of_prize2')->nullable();
            $table->time('time_of_prize3')->nullable();
            $table->bigInteger('win_of_prize1')->nullable();
            $table->bigInteger('win_of_prize2')->nullable();
            $table->bigInteger('win_of_prize3')->nullable();
            $table->double('total_bitcoin')->nullable();
            $table->integer('is_end')->default(0);
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
        Schema::dropIfExists('lotteries');
    }
}
