<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('items_name', '50');
            $table->string('price');
            $table->text('description');
            $table->string('image')->nullable(true);
            $table->text('state');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->boolean('hide_flg')->nullable(true);
            $table->boolean('selling')->nullable(true);
            $table->string('path');
            
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
    
}
