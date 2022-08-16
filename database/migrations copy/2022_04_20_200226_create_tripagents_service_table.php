<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripAgentsServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripagents_service', function (Blueprint $table) {
            $table->id();
             // $table->Integer('service_id')->unsigned();
             $table->foreignId('service_id')->references('id')->on('serivces')
             ->onDelete('cascade')
             ->onUpdate('cascade');
 
             // $table->Integer('tripagent_id')->unsigned();
             $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
             ->onDelete('cascade')
             ->onUpdate('cascade');
 
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
        Schema::dropIfExists('agents_service');
    }
}
