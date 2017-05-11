<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment_conditions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('faculty_program_id');
            $table->integer('name');
            $table->integer('type');
            $table->string('conditions_subject')->nullable();
            $table->integer('conditions_profession')->nullable();
            $table->integer('weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollment_conditions');
    }
}
