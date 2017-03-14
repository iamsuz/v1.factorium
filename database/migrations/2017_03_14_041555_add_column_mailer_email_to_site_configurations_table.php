<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMailerEmailToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('site_configurations', 'mailer_email')) {
                $table->string('mailer_email')->nullable();
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
            if (!Schema::hasColumn('site_configurations', 'mailer_email')) {
                $table->dropColumn('mailer_email');
            }
        });
    }
}
