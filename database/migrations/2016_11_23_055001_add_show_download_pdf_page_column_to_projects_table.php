<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowDownloadPdfPageColumnToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('projects', 'show_download_pdf_page')){
            Schema::table('projects', function (Blueprint $table) {
                $table->boolean('show_download_pdf_page')->default(true);
            });           
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('show_download_pdf_page');
        });
    }
}
