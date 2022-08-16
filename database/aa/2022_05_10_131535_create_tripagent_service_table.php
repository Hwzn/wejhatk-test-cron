<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripagentServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripagent_service', function (Blueprint $table) {
            $table->id();
             $table->foreignId('service_id')->references('id')->on('serivces')
             ->onDelete('cascade')
             ->onUpdate('cascade');
 
             $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
             ->onDelete('cascade')
             ->onUpdate('cascade');
             
             $table->enum('status',['active','not_active'])->default('active');
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
        Schema::dropIfExists('tripagent_service');
    }
}
