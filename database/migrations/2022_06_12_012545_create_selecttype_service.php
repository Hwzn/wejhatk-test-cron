<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectTypeService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selecttype_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selecttype_id')->references('id')->on('select_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('service_id')->references('id')->on('serivces')
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
        Schema::dropIfExists('selecttype_service');
    }
}
