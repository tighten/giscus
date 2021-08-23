<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotifiedCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('notified_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('github_id')->unique();
            $table->timestamp('github_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('notified_comments');
    }
}
