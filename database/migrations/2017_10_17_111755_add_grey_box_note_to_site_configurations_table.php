<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGreyBoxNoteToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('site_configurations', 'grey_box_note')) {
                $table->text('grey_box_note');
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
        Schema::table('site_configurations', function (Blueprint $table) {
            if (Schema::hasColumn('site_configurations', 'grey_box_note')) {
                $table->dropColumn('grey_box_note');
            }    
        });
    }
}
