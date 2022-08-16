<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialMediaTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialmedia_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status',['active','not_active'])->default('active');
            $table->timestamps();
        });
    }

    /**dd
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialmedia_types');
    }
}
