<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickSerivcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_serivces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tripagent_serviceid')->references('id')->on('tripagents_service')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('request_typeid')->references('id')->on('request_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('destination_id')->references('id')->on('destinations')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('traveltype_id')->references('id')->on('travel_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('userneed_id')->references('id')->on('user_needs')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->text('details');
            $table->string('Prefer_communicationtime');
            $table->foreignId('communicationway_id')->references('id')->on('prefer_communicationways')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->enum('status',['pending','confirmed','refused']);
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
        Schema::dropIfExists('quick_serivces');
    }
}
