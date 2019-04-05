<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects',function (Blueprint $table) {
            $table->string('contract_address')->nullable();
            $table->boolean('is_wallet_tokenized')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects',function (Blueprint $table) {
            $table->dropColumn('contract_address');
            $table->dropColumn('is_wallet_tokenized');
        });
    }
}
