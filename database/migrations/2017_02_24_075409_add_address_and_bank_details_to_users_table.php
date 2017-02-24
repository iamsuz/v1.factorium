<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressAndBankDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_name')->nullable();
            $table->string('bsb')->nullable();
            $table->string('account_number')->nullable();
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country', 30)->nullable();
            $table->string('country_code', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_name');
            $table->dropColumn('bsb');
            $table->dropColumn('account_number');
            $table->dropColumn('line_1');
            $table->dropColumn('line_2');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('postal_code');
            $table->dropColumn('country', 30);
            $table->dropColumn('country_code', 5);
        });
    }
}
