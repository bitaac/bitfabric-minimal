<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitaacStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__bitaac_store_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('count');
            $table->string('title', 255);
            $table->string('description', 255)->nullable()->default(null);
            $table->integer('points');
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
        Schema::drop('__bitaac_store_products');
    }
}
