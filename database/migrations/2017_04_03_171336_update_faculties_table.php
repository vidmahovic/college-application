<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function(Blueprint $table) {
            $table->dropColumn(['address', 'city_id']);
            $table->integer('university_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->string('acronym');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function(Blueprint $table) {
            $table->string('address');
            $table->integer('city_id')->unsigned();
            $table->dropColumn(['university_id', 'district_id', 'acronym']);
        });
    }
}
