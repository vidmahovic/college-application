<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateApplicationsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function($table) {
            $table->integer('phone')->nullable();
            $table->dropColumn('middle_name');
            $table->dropColumn('nationality_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function($table) {
            $table->dropColumn('phone');
            $table->string('middle_name')->nullable();
            $table->integer('nationality_type_id')->nullable();
        });
    }
}
