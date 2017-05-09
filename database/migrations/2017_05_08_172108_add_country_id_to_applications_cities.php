<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdToApplicationsCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_cities', function(Blueprint $table) {
            $table->integer('country_name')->change();
            $table->renameColumn('country_name','country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_cities', function(Blueprint $table) {
            $table->renameColumn('country_id','country_name');
        });

        Schema::table('application_cities', function(Blueprint $table) {
            $table->string('country_name')->change();
        });
    }
}
