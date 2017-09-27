<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExplainerVideoUrlToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
                if (!Schema::hasColumn('site_configurations', 'explainer_video_url')) {
                $table->string('explainer_video_url')->nullable();
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
                if (Schema::hasColumn('site_configurations', 'explainer_video_url')) {
                $table->dropColumn('explainer_video_url');
            }
        });
    }
}
