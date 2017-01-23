<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHomepgBtn1TextColumnToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('site_configurations', 'homepg_btn1_text')) {
                $table->string('homepg_btn1_text')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (Schema::hasColumn('site_configurations', 'homepg_btn1_text')) {
                $table->dropColumn('homepg_btn1_text');
            }
        });
    }
}
