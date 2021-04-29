<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('medicines_id');
            $table->integer('qty');
            $table->string('desc')->nullable();
            $table->string('rule')->nullable();
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
        Schema::dropIfExists('transactions_medicines');
    }
}
