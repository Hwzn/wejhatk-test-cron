<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripagentStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripagent_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onDelete('CasCade')
            ->onUpdate('CasCade');
            $table->integer('requests_count');
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
        Schema::dropIfExists('tripagent_statistics');
    }
}
