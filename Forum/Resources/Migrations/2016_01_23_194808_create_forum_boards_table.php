<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__bitaac_forum_boards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('slug')->nullable()->default(null);
            $table->string('description', 150)->nullable()->default(null);
            $table->integer('news')->default(0);
            $table->integer('order')->default(0);
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
        Schema::drop('__bitaac_forum_boards');
    }
}
