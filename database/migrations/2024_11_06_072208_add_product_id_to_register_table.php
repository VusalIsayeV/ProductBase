<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToRegisterTable extends Migration
{
    public function up()
    {
        Schema::table('register', function (Blueprint $table) {
            $table->unsignedBigInteger('ProductId')->after('id'); // ProductId kolonunu ekle
            $table->foreign('ProductId')->references('id')->on('product')->onDelete('cascade'); // Foreign key ile ilişkilendir
        });
    }

    public function down()
    {
        Schema::table('register', function (Blueprint $table) {
            $table->dropForeign(['ProductId']); // Foreign key'i kaldır
            $table->dropColumn('ProductId'); // ProductId kolonunu kaldır
        });
    }
}
