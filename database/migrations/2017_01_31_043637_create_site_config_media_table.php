<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteConfigMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_config_media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_configuration_id')->unsigned();
            $table->foreign('site_configuration_id')->references('id')->on('site_configurations')->onDelete('cascade');
            $table->string('type')->default('gallery_image');
            $table->string('filename');
            $table->string('path');
            $table->string('thumbnail_path')->nullable();
            $table->text('caption')->nullable();
            $table->string('extension');
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
        Schema::drop('site_config_media');
    }
}
