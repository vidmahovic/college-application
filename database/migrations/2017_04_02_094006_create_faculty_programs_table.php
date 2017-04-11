<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_programs', function (Blueprint $table) {
            $table->increments('id'); // PK
            $table->string('name', 256);
            $table->integer('faculty_id')->unsigned(); // FK
            $table->boolean('allow_double_degree'); // int(1)
            $table->boolean('is_regular');
            $table->integer('min_points'); //int(3)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_programs');
    }
}
