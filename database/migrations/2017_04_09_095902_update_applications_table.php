<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function(Blueprint $table) {
            $table->string('address');
            $table->integer('country_id')->unsigned();
            $table->integer('citizen_id')->unsigned();
            $table->integer('application_city_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function(Blueprint $table) {
            $table->dropColumn(['address', 'country_id', 'citizen_id', 'application_city_id']);
        });
    }
}
