<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFounderLabelToAboutusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aboutus', function (Blueprint $table) {
                if (!Schema::hasColumn('aboutus', 'founder_label')) {
                $table->string('founder_label')->default('Founders');
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
        Schema::table('aboutus', function (Blueprint $table) {
                if (Schema::hasColumn('aboutus', 'founder_label')) {
                $table->dropColumn('founder_label');
            }
        });
    }
}
