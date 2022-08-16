<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade')
            ->nullable();
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade')
            ->nullable();
            $table->foreignId('tourguide_id')->references('id')->on('tour_guides')
            ->onDelete('cascade')
            ->onUpdate('cascade')
            ->nullable();
            $table->text('token');
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
        Schema::dropIfExists('device_tokens');
    }
}
