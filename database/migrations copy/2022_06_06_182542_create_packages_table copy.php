<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('destination',191);
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade')
            ->nullable();
            $table->foreignId('currency_id')->references('id')->on('currencies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('price');
            $table->string('person_num');
            $table->integer('days');
            $table->integer('rate')->nullable();
            $table->text('package_desc')->nullable();
            $table->text('package_contain')->nullable();
            $table->text('conditions')->nullable();
            $table->text('cancel_conditions')->nullable();
            $table->text('package_notinclude')->nullable();
            $table->text('ReturnPloicy')->nullable();
            $table->string('photo')->nullable();
            // $table->foreignId('ReturnPloicy_id')->references('id')->on('retrun_ploicies')
            //   ->onDelete('cascade')
            //     ->onUpdate('cascade');
            $table->enum('status',['active','notactive'])->default('active');
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
        Schema::dropIfExists('packages');
    }
}
