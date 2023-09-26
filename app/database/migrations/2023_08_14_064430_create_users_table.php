<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', '30');
            $table->string('password', '255');
            $table->boolean('stop_flg')->nullable(true);
            $table->softDeletes();
            $table->text('introduction')->nullable(true);
            $table->string('name', '20');
            $table->string('icon')->nullable(true);
            $table->string('remember_token', '100')->nullable(true);
            $table->string('path')->nullable(true);
            $table->string('role')->nullable(true)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
