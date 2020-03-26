<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitaacForumPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__bitaac_forum_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id');
            $table->integer('player_id');
            $table->integer('belongs_to')->default(0);
            $table->string('title', 500);
            $table->string('slug')->nullable()->default(null);
            $table->integer('views')->default(0);
            $table->longText('content');
            $table->bigInteger('lastip')->default(0);
            $table->integer('timestamp');
            $table->integer('locked')->default(0);
            $table->integer('sticked')->default(0);
            $table->integer('edited_at')->default(0);
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
        Schema::drop('__bitaac_forum_posts');
    }
}
