<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmbeddedLinkColumnToInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->string('embedded_offer_doc_link')->nullable();
            $table->string('PDS_part_1_link')->nullable();
            $table->string('PDS_part_2_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('embedded_offer_doc_link');
            $table->dropColumn('PDS_part_1_link');
            $table->dropColumn('PDS_part_2_link');
        });
    }
}
