<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('line_1');
            $table->string('line_2')->nullable();
            $table->string('street')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country', 30);
            $table->string('country_code', 5);
            $table->string('phone_number')->nullable();
            $table->double('latitude',11,7)->nullable();
            $table->double('longitude',11,7)->nullable();
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
        Schema::drop('locations');
    }
}
