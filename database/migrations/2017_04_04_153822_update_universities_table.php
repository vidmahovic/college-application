<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TODO (Vid to Rok): Tukaj spreminjas increments v integer. Pomoje to ni potrebno, ker gre za isto stvar.
//        Schema::table('universities', function($table) {
//            $table->integer('id')->change();
//        });
//
//        Schema::table('districts', function($table) {
//            $table->integer('id')->change();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('universities', function($table) {
//            $table->increments('id')->change();
//        });
//
//        Schema::table('districts', function($table) {
//            $table->increments('id')->change();
//        });
    }
}
