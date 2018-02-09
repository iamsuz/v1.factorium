<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('type'); //multifamily (project type)
            $table->text('additional_info')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamp('activated_on')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('completion_date')->nullable();
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
        Schema::drop('projects');
    }
}
