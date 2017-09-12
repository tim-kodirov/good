<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('remainder_id')->unsigned();
            $table->foreign('remainder_id')->references('id')->on('remainders');
            $table->string('toWhom');
            $table->integer('quantity')->unsigned();
            $table->boolean('return')->default(false);
            $table->integer('return_quantity')->nullable();
            $table->boolean('fromRequest');
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
        Schema::dropIfExists('exports');
    }
}
