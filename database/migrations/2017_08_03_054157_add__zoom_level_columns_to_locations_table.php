<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZoomLevelColumnsToLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
                if (!Schema::hasColumn('locations', 'zoom_level')) {
                $table->integer('zoom_level')->default(10);
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
        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasColumn('locations', 'zoom_level')) {
                $table->dropColumn('zoom_level');
            }
        });
    }
}
