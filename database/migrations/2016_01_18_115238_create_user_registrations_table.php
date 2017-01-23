<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('role');
            $table->string('password');
            $table->string('active')->default(0);
            $table->timestamp('activated_on')->nullable();
            $table->string('token')->unique()->nullable();
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
        Schema::drop('user_registrations');
    }
}
