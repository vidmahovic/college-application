<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaturaScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matura_scores', function(Blueprint $table) {
            $table->increments('id');
            $table->string('emso', '13');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_school_id');
            $table->string('profession_id');
            $table->integer('interval_id')->unsigned();
            $table->tinyInteger('matura_points')->unsigned();
            //$table->tinyInteger('matura_mark')->unsigned();
            $table->tinyInteger('third_grade_mark')->unsigned();
            $table->tinyInteger('fourth_grade_mark')->unsigned();
            $table->boolean('matura_done');
            $table->boolean('general_matura');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matura_scores');
    }
}
