<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedrecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medrecs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('medrec_name');
            $table->date('birthdate');
            $table->text('sex');
            $table->text('blood')->nullable();
            $table->text('religion')->nullable();
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->text('region')->nullable();
            $table->text('postalcode')->nullable();
            $table->text('parent')->nullable();
            $table->text('phone1')->nullable();
            $table->text('phone2')->nullable();
            $table->text('email')->nullable();
            $table->string('special_note')->nullable();
            $table->string('allergies')->nullable();
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
        Schema::dropIfExists('medrecs');
    }
}
