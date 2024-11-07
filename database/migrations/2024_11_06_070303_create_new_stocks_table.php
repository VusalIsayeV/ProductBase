<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewStocksTable extends Migration
{
    public function up()
    {
        Schema::create('new_stock', function (Blueprint $table) {
            $table->id(); // Id sütunu
            $table->unsignedBigInteger('product_id'); // Ürün ID
            $table->integer('count'); // Ürün sayısı
            $table->unsignedBigInteger('base_id'); // Base ID
            $table->timestamps(); // Created_at ve updated_at sütunları

            // Foreign key ilişkisi, ürün ve base tablolarıyla ilişki kurulur
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('base_id')->references('id')->on('base')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_stocks');
    }
}
