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
        Schema::create('cross_over_stations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('station_id');
            $table->integer('order');

            $table->foreign('trip_id')->references('id')->on('trips')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stations')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('cross_over_stations');
    }
};
