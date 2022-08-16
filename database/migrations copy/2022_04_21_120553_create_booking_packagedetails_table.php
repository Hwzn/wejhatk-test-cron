<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_packagedetails', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->references('id')->on('booking_packages')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->string('traveler_name');
            $table->string('traveler_age');
            $table->string('traveler_phone');

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
        Schema::dropIfExists('booking_packagedetails');
    }
}
