<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('print_type');
            $table->string('foreign_id');
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->string('field1')->nullable();
            $table->string('field2')->nullable();
            $table->string('field3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('printlogs');
    }
}
