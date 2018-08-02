<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnCommentToIdDocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('id_documents',  function(Blueprint $table){
            $table->text('id_comment')->nullabe();
            $table->text('joint_id_comment')->nullabe();
            $table->text('company_id_comment')->nullabe();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('id_documents',function (Blueprint $table)
        {
            $table->dropColumn('id_comment');
            $table->dropColumn('joint_id_comment');
            $table->dropColumn('company_id_comment');
        });
    }
}
