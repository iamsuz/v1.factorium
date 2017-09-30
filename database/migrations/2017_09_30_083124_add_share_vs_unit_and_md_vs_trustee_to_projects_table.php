<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShareVsUnitAndMdVsTrusteeToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('share_vs_unit')->default(1);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('md_vs_trustee')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('share_vs_unit');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('md_vs_trustee');
        });
    }
}
