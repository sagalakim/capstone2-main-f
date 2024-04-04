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
        Schema::create('report_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('itinerary_id')->nullable();
            $table->foreign('itinerary_id')->references('id')->on('itinerary_heads')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('accomplishment_id')->nullable();
            $table->foreign('accomplishment_id')->references('id')->on('accomplishment_heads')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('liquidation_id')->nullable();
            $table->foreign('liquidation_id')->references('id')->on('liquidations')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status');
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
        Schema::dropIfExists('itinerary_notification');
    }
};
