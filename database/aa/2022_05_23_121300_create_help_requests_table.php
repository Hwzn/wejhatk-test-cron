<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_num');
            $table->foreignId('user_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->foreignId('help_id')->references('id')->on('helps')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->text('request_details');
            $table->enum('status',['pending','solved','backed','closed'])->default('pending');
            $table->string('request_photo')->nullable();
            $table->text('admin_reply')->nullable();
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
        Schema::dropIfExists('help_requests');
    }
}
