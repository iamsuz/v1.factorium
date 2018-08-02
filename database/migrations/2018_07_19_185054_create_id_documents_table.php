<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type');
            $table->string('filename');
            $table->string('path');
            $table->string('investing_as');
            $table->string('joint_first_name')->nullable();
            $table->string('joint_last_name')->nullable();
            $table->string('trust_or_company')->nullable();
            $table->string('extension');
            $table->integer('verified')->default(0);
            $table->string('joint_id_filename')->nullable();
            $table->string('joint_id_path')->nullable();
            $table->string('joint_id_extension')->nullable();
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
        Schema::drop('id_documents');
    }
}
