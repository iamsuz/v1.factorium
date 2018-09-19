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
            $table->string('daily_login_bonus_konkrete')->default('10');
            $table->string('user_sign_up_konkrete')->default('100');
            $table->string('kyc_upload_konkrete')->default('200');
            $table->string('kyc_approval_konkrete')->default('200');
            $table->string('referrer_konkrete')->default('200');
            $table->string('referee_konkrete')->default('200');
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
            $table->dropColumn('referral_konkrete');
            $table->dropColumn('referee_konkrete');
        });
    }
}
