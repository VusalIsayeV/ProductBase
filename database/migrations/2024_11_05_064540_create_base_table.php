<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTable extends Migration
{
    public function up()
    {
        Schema::create('base', function (Blueprint $table) {
            $table->id();
            $table->string('BaseName');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('base');
    }
}
