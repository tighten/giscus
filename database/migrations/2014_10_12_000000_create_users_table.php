<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            // Cached from GitHub
            $table->string('github_id')->unique();
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('avatar');
            $table->string('token');

            //
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}
