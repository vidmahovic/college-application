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
        Schema::create('applications', function(Blueprint $table) {
            $table->increments('id');
            // Foreign keys / dependencies
            $table->integer('user_id')->unsinged()->nullable();
            $table->integer('application_interval_id')->unsinged()->nullable();
            $table->integer('middle_school_id')->unsinged()->nullable();
            $table->integer('education_type_id')->unsinged()->nullable();
            $table->integer('profession_id')->unsinged()->nullable();
            $table->integer('nationality_type_id')->unsigned()->nullable();
            // Application attributes
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->char('emso', 13)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('status', ['created', 'ready', 'edited', 'filed'])->default('created');
            $table->timestamps();
            $table->softDeletes();
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
