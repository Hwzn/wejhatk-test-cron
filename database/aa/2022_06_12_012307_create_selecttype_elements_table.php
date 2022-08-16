<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectTypeElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selecttype_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selecttype_id')->references('id')->on('select_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('name',191);
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
        Schema::dropIfExists('selecttype_elements');
    }
}
