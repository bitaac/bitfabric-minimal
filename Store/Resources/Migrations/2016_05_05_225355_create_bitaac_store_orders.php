<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitaacStoreOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__bitaac_store_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('player_id');
            $table->integer('item_id');
            $table->integer('count');
            $table->integer('claimed')->default(0);
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
        Schema::drop('__bitaac_store_orders');
    }
}
