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
            $table->string('cost_of_ticket')->nullable();
            $table->string('description')->nullable();
            $table->string('time_of_prize1')->nullable();
            $table->string('time_of_prize2')->nullable();
            $table->string('time_of_prize3')->nullable();
            $table->bigInteger('win_of_prize1')->nullable();
            $table->bigInteger('win_of_prize2')->nullable();
            $table->bigInteger('win_of_prize3')->nullable();
            $table->string('total_bitcoin')->nullable();
            $table->integer('is_end')->default(0);
            $table->boolean('is_paid')->default(0);
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
