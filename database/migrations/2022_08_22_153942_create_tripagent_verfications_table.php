<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripagentVerficationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripagent_verfications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('trip_agents')
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
        Schema::dropIfExists('tripagent_verfications');
    }
}
