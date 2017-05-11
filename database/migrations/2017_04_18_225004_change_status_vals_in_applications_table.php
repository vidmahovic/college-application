<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStatusValsInApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function(Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('applications', function(Blueprint $table) {
            $table->enum('status', ['created', 'saved', 'filed'])->default('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function(Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('applications', function(Blueprint $table) {
            $table->enum('status', ['created', 'ready', 'edited', 'filed'])->default('created');
        });
    }
}
