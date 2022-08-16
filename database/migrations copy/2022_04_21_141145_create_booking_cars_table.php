<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tripagent_serviceid')->references('id')->on('tripagents_service')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->text('from_location');
            $table->text('to_location');
            $table->date('from_date');
            $table->date('to_date');

            $table->foreignId('car_id')->references('id')->on('tripagent_cars')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('Prefer_communicationtime');

            $table->foreignId('communicationway_id')->references('id')->on('prefer_communicationways')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->enum('status',['pending','confirmed','refused']);

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
        Schema::dropIfExists('booking_cars');
    }
}
