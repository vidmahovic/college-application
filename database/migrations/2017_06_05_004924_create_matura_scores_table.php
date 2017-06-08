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
            $table->tinyInteger('matura_points')->unsigned()->nullable()->default(null);
            //$table->tinyInteger('matura_mark')->unsigned();
            $table->tinyInteger('third_grade_mark')->unsigned()->nullable()->default(null);
            $table->tinyInteger('fourth_grade_mark')->unsigned()->nullable()->default(null);
            $table->boolean('matura_done')->nullable()->default(null);
            $table->boolean('general_matura')->nullable()->default(null);
        });

        Schema::table('matura_scores', function (Blueprint $table) {
            $table->index('emso');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matura_scores', function (Blueprint $table) {
            $table->dropIndex(['emso']);
        });
        Schema::dropIfExists('matura_scores');
    }
}
