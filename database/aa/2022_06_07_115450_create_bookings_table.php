<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('User_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('Tripagent_id')->nullable()->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('Tourguide_id')->nullable()->references('id')->on('tour_guides')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreignId('Service_id')->references('id')->on('serivces')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('Package_id')->nullable()->references('id')->on('packages')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->text('booking_details');
            $table->string('booking_file')->nullable();
            $table->enum('status',['pending','accepted','completed','refused'])->default('pending');
            $table->softDeletes();
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
        Schema::dropIfExists('bookings');
    }
}
