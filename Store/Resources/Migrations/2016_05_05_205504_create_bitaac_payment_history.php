<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitaacPaymentHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('__bitaac_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_id', 255);
            $table->string('method', 50);
            $table->string('currency');
            $table->string('amount');
            $table->integer('account_id');
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
        Schema::drop('__bitaac_payments');
    }
}
