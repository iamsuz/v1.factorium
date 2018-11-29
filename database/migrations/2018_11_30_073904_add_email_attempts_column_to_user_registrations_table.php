<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailAttemptsColumnToUserRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->integer('email_attempts')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->dropColumn('email_attempts');
        });
    }
}
