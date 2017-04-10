<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emso');
            $table->date('date_of_birth');          
            $table->timestamp('deleted_at');
            $table->timestamps();
            //FKs
            $table->integer('middle_school_id');
            $table->integer('education_type_id');
            $table->integer('profession_id');
            $table->integer('application_interval_id');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
