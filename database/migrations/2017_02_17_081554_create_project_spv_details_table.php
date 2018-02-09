<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSpvDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_spv_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('spv_name');
            $table->string('spv_line_1');
            $table->string('spv_line_2')->nullable();
            $table->string('spv_city');
            $table->string('spv_state');
            $table->string('spv_postal_code');
            $table->string('spv_country');
            $table->string('spv_contact_number');
            $table->string('spv_md_name');
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
        Schema::drop('project_spv_details');
    }
}
