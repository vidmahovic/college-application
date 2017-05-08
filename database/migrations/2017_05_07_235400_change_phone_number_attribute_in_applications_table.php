<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePhoneNumberAttributeInApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function(Blueprint $table) {
            $table->dropColumn(['phone']);
        });

        Schema::table('applications', function(Blueprint $table) {
            $table->string('phone', 16)->nullable();
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
            $table->dropColumn(['phone']);
        });

        Schema::table('applications', function(Blueprint $table) {
            $table->integer('phone')->nullable();
        });
    }
}
