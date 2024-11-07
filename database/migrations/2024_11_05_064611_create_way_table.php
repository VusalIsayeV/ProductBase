<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWayTable extends Migration
{
    public function up()
    {
        Schema::create('way', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ToBase');
            $table->unsignedBigInteger('FromBase');
            $table->integer('SendNum');
            $table->timestamps();

            $table->foreign('ToBase')->references('id')->on('base')->onDelete('cascade');
            $table->foreign('FromBase')->references('id')->on('base')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('way');
    }
}
