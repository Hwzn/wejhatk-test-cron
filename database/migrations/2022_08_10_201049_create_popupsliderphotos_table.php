<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupSliderPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popupsliderphotos', function (Blueprint $table) {
            $table->id();
            $table->string('photo',191);
            $table->dateTime('expired_at')->nullable();
            $table->enum('status',['active','notactive'])->default('notactive');
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
        Schema::dropIfExists('popupsliderphotos');
    }
}
