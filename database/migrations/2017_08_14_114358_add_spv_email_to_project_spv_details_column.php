<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpvEmailToProjectSpvDetailsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_spv_details', function (Blueprint $table) {
            $table->string('spv_email')->default('info@estatebaron.com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_spv_details', function (Blueprint $table) {
            $table->string('spv_email');
        });
    }
}
