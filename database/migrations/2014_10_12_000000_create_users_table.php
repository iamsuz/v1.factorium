<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique()->index();
            $table->string('password', 60);
            $table->string('phone_number', 15)->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('gender', 11)->nullable();
            $table->timestamp('last_login')->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('verify_id')->default(0);
            $table->timestamp('activated_on')->nullable();
            $table->string('activation_token')->unique()->nullable()->index();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::drop('users');
    }
}
