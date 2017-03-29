<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_configuration_id')->unsigned();
            $table->foreign('site_configuration_id')->references('id')->on('site_configurations');
            $table->string('driver')->default('smtp');
            $table->string('host')->default('smtp.gmail.com');
            $table->string('port')->default('587');
            $table->string('from')->default('info@estatebaron.com');
            $table->string('username')->default('info@estatebaron.com');
            $table->string('password', 60);
            $table->string('encryption')->default('tls');
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
        Schema::drop('mail_settings');
    }
}
