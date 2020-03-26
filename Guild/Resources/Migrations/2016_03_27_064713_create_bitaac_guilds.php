<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Bitaac\Core\Facades\Database\Trigger;
use Illuminate\Database\Migrations\Migration;

class CreateBitaacGuilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__bitaac_guilds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guild_id');
            $table->string('description')->nullable()->default(null);
            $table->string('logo', 255)->nullable()->default(null);
            $table->timestamps();
        });

        Trigger::after('insert')->on('guilds')->create(function ($query) {
            $query->table('__bitaac_guilds')->insert([
                'guild_id'   => DB::raw('NEW.`id`'),
                'created_at' => DB::raw('now()'),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Trigger::after('insert')->on('guilds')->rollback();

        Schema::drop('__bitaac_guilds');
    }
}
