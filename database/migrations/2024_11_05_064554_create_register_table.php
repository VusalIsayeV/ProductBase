<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRegisterTable extends Migration
{
    public function up()
    {
        Schema::table('register', function (Blueprint $table) {
            // ProductId əlavə edilir
            $table->unsignedBigInteger('ProductId');

            // Sütunları çıxarırıq
            $table->dropColumn(['ProductName', 'Unit', 'Status', 'Barcode']);

            // Foreign key əlavə edilir
            $table->foreign('ProductId')->references('id')->on('product')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('register', function (Blueprint $table) {
            // Əlavə etdiyimiz sütunları geri çıxardırıq
            $table->dropForeign(['ProductId']);
            $table->dropColumn('ProductId');

            // Əvvəlki sütunları bərpa edirik
            $table->string('ProductName');
            $table->string('Unit');
            $table->string('Status');
            $table->string('Barcode')->unique();
        });
    }
}
