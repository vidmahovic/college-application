<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnrollmentConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrollment_conditions', function(Blueprint $table) {
            $table->renameColumn('conditions_subject', 'conditions_subject_id');
            $table->renameColumn('conditions_profession', 'conditions_profession_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrollment_conditions', function(Blueprint $table) {
            $table->renameColumn('conditions_subject_id', 'conditions_subject');
            $table->renameColumn('conditions_profession_id', 'conditions_profession');
        });
    }
}
