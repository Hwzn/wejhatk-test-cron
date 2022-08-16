<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripagentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
          
            $table->string('phone')->unique();
            $table->timestamp('verified_at')->nullable();
            $table->string('password');
            $table->enum('type',['Tourism_Company','educational_service']);
            $table->string('address')->nullable();
            $table->integer('starnumber')->nullable();
            $table->integer('evaulation')->nullable();
            $table->string('photo')->nullable();
            $table->string('profile_photo')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->foreignId('agency_id')->references('id')->on('agency_types')
            ->onUpdate('CasCade');
            $table->text('countries')->nullable();
            $table->string('commercial_registrationNo')->nullable();
            $table->date('commercialregistration_expiryDate')->nullable();
            $table->string('license_number',191)->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->enum('status',['active','not_active'])->default('not_active');

            

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tripagents');
    }
}
