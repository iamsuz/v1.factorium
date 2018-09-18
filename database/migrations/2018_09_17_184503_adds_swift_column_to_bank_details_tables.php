<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsSwiftColumnToBankDetailsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('swift_code')->nullable();
        });
        Schema::table('investing_joint', function (Blueprint $table) {
            $table->string('swift_code')->nullable();
        });
        Schema::table('investments', function (Blueprint $table) {
            $table->string('swift_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropCoulumn('swift_code');
        });
        Schema::table('investing_joint', function (Blueprint $table) {
            $table->dropCoulumn('swift_code');
        });
        Schema::table('investing_joint', function (Blueprint $table) {
            $table->dropCoulumn('swift_code');
        });
    }
}
