<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultionTypeTourguidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultiontype_tourguide', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourguide_id')->references('id')->on('tour_guides')
            ->onUpdate('CasCade');
            $table->foreignId('consultiontype_id')->references('id')->on('consultation_types')
            ->onUpdate('CasCade');
            $table->enum('status',['active','not_active'])->default('active');
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
        Schema::dropIfExists('consultion_type_tourguides');
    }
}
