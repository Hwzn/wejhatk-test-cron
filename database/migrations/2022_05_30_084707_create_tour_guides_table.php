<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_guides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->integer('starnumber')->nullable();
            $table->integer('evaulation')->nullable();
            $table->string('photo')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onUpdate('CasCade')->nullable();
            $table->text('countries')->nullable();
            $table->string('commercial_registrationNo')->nullable();
            $table->date('commercialregistration_expiryDate')->nullable();
            $table->string('license_number',191)->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->enum('status',['active','not_active'])->default('not_active');
            $table->string('cv',191)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_guides');
    }
}
