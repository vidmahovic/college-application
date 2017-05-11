<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('api_token')->unique()->nullable();
            $table->integer('role_id')->unsigned();
            $table->timestamp('activation_email_sent_at')->nullable();
            $table->timestamp('activation_expires_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
