<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHomepgText1ColumnToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('site_configurations', 'homepg_text1')) {
                $table->string('homepg_text1')->nullable();
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
            if (Schema::hasColumn('site_configurations', 'homepg_text1')) {
                $table->dropColumn('homepg_text1');
            }
        });
    }
}
