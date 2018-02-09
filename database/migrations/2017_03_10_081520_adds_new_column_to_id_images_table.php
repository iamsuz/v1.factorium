<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsNewColumnToIdImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('id_images', function (Blueprint $table) {
            $table->text('fixing_message')->nullable();
            $table->text('fixing_message_for_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('id_images', function (Blueprint $table) {
            $table->dropColumn('fixing_message');
            $table->dropColumn('fixing_message_for_id');
        });
    }
}
