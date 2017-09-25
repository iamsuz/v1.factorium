<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProspectusTextColumnToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
                if (!Schema::hasColumn('site_configurations', 'prospectus_text')) {
                $table->string('prospectus_text')->nullable();
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
                if (Schema::hasColumn('site_configurations', 'prospectus_text')) {
                $table->dropColumn('prospectus_text');
            }
        });
    }
}
