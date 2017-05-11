<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAutoIncrementingPrimaryKeys extends Migration
{

    private $tables = ['universities', 'professions', 'districts', 'citizens', 'faculties', 'graduation_types'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->tables as $table) {
            Schema::table($table, function(Blueprint $t) {
                $t->dropColumn(['id']);
            });

            Schema::table($table, function(Blueprint $t) {
               $t->integer('id')->unsigned()->first();
               $t->primary('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->tables as $table) {
            Schema::table($table, function(Blueprint $t) {
                $t->dropColumn(['id']);
            });

            Schema::table($table, function(Blueprint $t) {
                $t->increments('id')->first();
            });
        }
    }
}
