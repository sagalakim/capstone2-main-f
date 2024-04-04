<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidation_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); //added
            $table->unsignedBigInteger('liquidation_id')->nullable(); //added
            $table->foreign('liquidation_id')->references('id')->on('liquidations')->onUpdate('cascade')->onDelete('cascade');
            $table->date('date')->nullable(); // edited not migrated yet
            $table->string('travel_itinerary_from');
            $table->string('travel_itinerary_to');
            $table->string('reference');
            $table->string('particulars');
            $table->integer('transpo');
            $table->integer('hotel');
            $table->integer('meals');
            $table->string('sundry');
            $table->integer('amount');
            $table->integer('row_total');
            $table->integer('total');
            $table->integer('cash_advance');
            $table->integer('for_or');
            //$table->string('receipt');    -- yet to migrate
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
        Schema::dropIfExists('liquidation_data');
    }
};
