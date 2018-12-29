<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentUrlColumnToUsersInvestmentDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_investment_documents',function (Blueprint $table){
            $table->string('document_url')->default('https://konkrete.estatebaron.com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_investment_documents',function (Blueprint $table){
            $table->dropColumn('document_url');
        });
    }
}
