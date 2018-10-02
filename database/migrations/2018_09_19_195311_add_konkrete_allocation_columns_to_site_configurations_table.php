<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKonkreteAllocationColumnsToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            $table->string('daily_login_bonus_konkrete');
            $table->string('user_sign_up_konkrete');
            $table->string('kyc_upload_konkrete');
            $table->string('kyc_approval_konkrete');
            $table->string('referrer_konkrete');
            $table->string('referee_konkrete');
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
            $table->dropColumn('daily_login_bonus_konkrete');
            $table->dropColumn('user_sign_up_konkrete');
            $table->dropColumn('kyc_upload_konkrete');
            $table->dropColumn('kyc_approval_konkrete');
            $table->dropColumn('referrer_konkrete');
            $table->dropColumn('referee_konkrete');
        });
    }
}
