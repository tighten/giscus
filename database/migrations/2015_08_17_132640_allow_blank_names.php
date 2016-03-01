<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowBlankNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Moved to origin because SQlite ¯\(°_o)/¯
        /*
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Dropped for now because SQlite ¯\(°_o)/¯
        // DB::statement('ALTER TABLE `users` MODIFY `name` VARCHAR(255) NOT NULL');

        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('name')->change();
        // });
    }
}
