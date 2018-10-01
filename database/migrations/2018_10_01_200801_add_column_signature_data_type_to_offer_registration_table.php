<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSignatureDataTypeToOfferRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_registrations',function (Blueprint $table)
        {
            $table->boolean('signature_type')->default(0);
            $table->text('signature_data_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offer_registrations',function (Blueprint $table)
        {
            $table->dropColumn('signature_type');
            $table->dropColumn('signature_data_type');
        });
    }
}
