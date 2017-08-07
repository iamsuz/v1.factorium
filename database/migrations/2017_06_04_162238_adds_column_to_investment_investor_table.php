<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsColumnToInvestmentInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_investor', function(Blueprint $table){
            if (!Schema::hasColumn('investment_investor', 'share_certificate_issued_at')) {
                $table->dateTime('share_certificate_issued_at')->nullable();
            }
            if (!Schema::hasColumn('investment_investor', 'share_number')) {
                $table->string('share_number')->nullable();
            }
            if (!Schema::hasColumn('investment_investor', 'share_certificate_path')) {
                $table->string('share_certificate_path')->nullable();
            }
            if (!Schema::hasColumn('investment_investor', 'is_cancelled')) {
                $table->boolean('is_cancelled')->default(0);
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
        Schema::table('investment_investor', function(Blueprint $table){
            if (Schema::hasColumn('investment_investor', 'share_certificate_issued_at')) {
                $table->dropColumn('share_certificate_issued_at');
            }
            if (Schema::hasColumn('investment_investor', 'share_number')) {
                $table->dropColumn('share_number');
            }
            if (Schema::hasColumn('investment_investor', 'share_certificate_path')) {
                $table->dropColumn('share_certificate_path');
            }
            if (Schema::hasColumn('investment_investor', 'is_cancelled')) {
                $table->dropColumn('is_cancelled');
            }
        });
    }
}
