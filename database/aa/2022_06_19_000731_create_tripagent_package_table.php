<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripagentPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripagent_package', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('package_id')->references('id')->on('packages')
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
        Schema::dropIfExists('tripagent_package');
    }
}
