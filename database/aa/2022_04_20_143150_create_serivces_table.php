<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerivcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serivces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type',['basic','additional'])->nullable('basic');
            $table->text('desc')->nullable();
            $table->enum('status',['active','not_active'])->default('active');
            $table->string('photo')->nullabel();
            $table->softDeletes();
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
        Schema::dropIfExists('serivces');
    }
}
