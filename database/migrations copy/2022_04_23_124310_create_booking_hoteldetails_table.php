<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingHotelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_hoteldetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->references('id')->on('booking_hotels')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('child_name');
            $table->string('child_age');
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
        Schema::dropIfExists('booking_hoteldetails');
    }
}
