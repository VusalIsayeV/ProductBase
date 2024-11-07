<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnnecessaryColumnsFromRegisterTable extends Migration
{
    public function up()
    {
        Schema::table('register', function (Blueprint $table) {
            // Gereksiz sütunları siliyoruz
            $table->dropColumn(['ProductName', 'Unit', 'Status', 'Barcode']);
        });
    }

    public function down()
    {
        Schema::table('register', function (Blueprint $table) {
            // Geri alma işlemi için sütunları tekrar ekliyoruz
            $table->string('ProductName');
            $table->string('Unit');
            $table->string('Status');
            $table->string('Barcode')->unique();
        });
    }
}
