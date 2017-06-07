<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_score', function(Blueprint $table) {
            $table->string('subject_id');
            $table->integer('matura_score_id')->unsigned();
            $table->tinyInteger('matura_mark')->unsigned();
            $table->tinyInteger('third_grade_mark')->unsigned()->nullable()->default(null);
            $table->tinyInteger('fourth_grade_mark')->unsigned()->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_score');
    }
}
