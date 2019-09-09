<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRegisteredFromInvoiceColumnToRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_registrations', function($table) {
            $table->boolean('registered_from_invoice');
        });
        Schema::table('users', function($table) {
            $table->boolean('registered_from_invoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_registrations', function($table) {
            $table->dropColumn('registered_from_invoice');
        });
        Schema::table('users', function($table) {
            $table->dropColumn('registered_from_invoice');
        });
    }
}
