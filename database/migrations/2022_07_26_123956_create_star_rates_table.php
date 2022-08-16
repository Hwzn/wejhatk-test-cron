<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('star_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_userid')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('to_tripagentid')->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->foreignId('to_tourguideid')->references('id')->on('tour_guides')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->integer('stars_rated')->default(0);
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
        Schema::dropIfExists('star_rates');
    }
}
