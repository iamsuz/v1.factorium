<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOfferDocColumnInProjectEoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_eoi', function (Blueprint $table) {
            if (!Schema::hasColumn('project_eoi', 'offer_doc_path')) {
                $table->string('offer_doc_path')->nullable();
            }
            if (!Schema::hasColumn('project_eoi', 'offer_doc_name')) {
                $table->string('offer_doc_name')->nullable();
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
        Schema::table('project_eoi', function (Blueprint $table) {
            if (Schema::hasColumn('project_eoi', 'offer_doc_path')) {
                $table->dropColumn('offer_doc_path');
            }
            if (Schema::hasColumn('project_eoi', 'offer_doc_name')) {
                $table->dropColumn('offer_doc_name');
            }
        });
    }
}
