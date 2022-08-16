<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourguideVerficationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourguide_verfications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('tour_guides')
            ->onDelete('CasCade')
            ->onUpdate('CasCade');
            $table->string('otpcode');
            $table->dateTime('expired_at');
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
        Schema::dropIfExists('tourguide_verfications');
    }
}
