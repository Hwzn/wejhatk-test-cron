<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_socialmedia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adstype_id')->references('id')->on('ads')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->foreignId('tripagent_id')->references('id')->on('trip_agents')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->string('agency_name',191);
            $table->string('phone',20)->unique();
            $table->string('email',50)->nullable();
            $table->string('social_media_platform',191)->nullable();
            $table->string('number_of_times_placed_ads',10)->nullable();
            $table->string('ads_type',191)->nullable();
            $table->text('ads_description')->nullable();
            $table->string('photo',191)->nullable();
            $table->boolean('agency_logo')->nullable();
            $table->string('ads_date')->nullable();
            $table->string('ads_time')->nullable();
            $table->text('addational_information')->nullable();
            $table->text('campaign_duration')->nullable();
            $table->text('admin_desc')->nullable();
            $table->double('actual_price')->nullable();
            $table->foreignId('currency_id')->references('id')->on('currencies')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->enum('status',['pending','confirmed','refused','paid','valid','expired'])->default('pending');
            $table->integer('appearance_order')->nullable();
            $table->string('duration',191)->nullable();
            $table->date('expire_at')->nullable();
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
        Schema::dropIfExists('ads_socialmedia');
    }
}
