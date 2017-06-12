<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGradesTableAdd3GradeMark4GradeMarkMaturaMarkAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function(Blueprint $table) {
            $table->integer('third_grade_mark')->unsigned()->nullable()->default(null)->after('subject_id');
            $table->integer('fourth_grade_mark')->unsigned()->nullable()->default(null)->after('third_grade_mark');
            $table->renameColumn('grade', 'matura_mark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function(Blueprint $table) {
            $table->dropColumn(['fourth_grade_mark', 'third_grade_mark']);
            $table->renameColumn('matura_mark', 'grade');
        });
    }
}
