<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_registration_id')->unsigned();
            $table->foreign('user_registration_id')->references('id')->on('user_registrations');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('investment_id')->unsigned();
            $table->foreign('investment_id')->references('id')->on('investments');
            $table->double('amount_to_invest', 20,2);
            $table->string('investing_as');
            $table->string('joint_fname')->nullable();
            $table->string('joint_lname')->nullable();
            $table->string('trust_company')->nullable();
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
            $table->string('tfn')->nullable();
            $table->longText('signature_data')->nullable();
            $table->string('application_path')->nullable();
            $table->tinyInteger('interested_to_buy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('offer_registrations');
    }
}
