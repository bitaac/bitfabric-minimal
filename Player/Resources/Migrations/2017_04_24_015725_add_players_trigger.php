<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Bitaac\Core\Facades\Database\Trigger;
use Illuminate\Database\Migrations\Migration;

class AddPlayersTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Trigger::after('delete')->on('players')->create(function ($query) {
            $query->table('__bitaac_players')->where('player_id', DB::raw('OLD.`id`'))->delete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Trigger::after('delete')->on('players')->rollback();
    }
}
