<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePdsPart1LinkColumnTypeStringToTextFromTableInvestments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investments',function (Blueprint $table)
        {
            $table->text('PDS_part_1_link')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investments',function (Blueprint $table)
        {
            $table->string('PDS_part_1_link')->change();
        });
    }
}
