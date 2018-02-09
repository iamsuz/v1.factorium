<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowSocialIconsToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
             if (!Schema::hasColumn('site_configurations', 'show_social_icons')) {
                $table->string('show_social_icons')->default('on');
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
            if (Schema::hasColumn('site_configurations', 'show_social_icons')) {
                $table->dropColumn('show_social_icons');
            }
        });
    }
}
