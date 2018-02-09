<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectSpvDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_spv_details', function (Blueprint $table) {
            if (!Schema::hasColumn('project_spv_details', 'certificate_frame')) {
                $table->string('certificate_frame')->nullable();
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
        Schema::table('project_spv_details', function (Blueprint $table) {
            if (Schema::hasColumn('project_spv_details', 'certificate_frame')) {
                $table->dropColumn('certificate_frame');
            }
        });
    }
}
