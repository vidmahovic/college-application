<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMaturaScoresTableRemoveFirstNameLastNameAndIntervalIdAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matura_scores', function(Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'interval_id', 'middle_school_id', 'emso', 'profession_id']);
            $table->integer('application_id')->unsigned()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matura_scores', function(Blueprint $table) {
            $table->dropColumn(['application_id']);
            $table->string('emso', '13');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_school_id');
            $table->string('profession_id');
            $table->integer('interval_id')->unsigned();
        });

        Schema::table('matura_scores', function (Blueprint $table) {
            $table->index('emso');
        });

    }
}
