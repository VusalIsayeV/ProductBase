<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToWayTable extends Migration
{
    public function up()
    {
        Schema::table('way', function (Blueprint $table) {
            // product_id sütununu unsignedBigInteger olaraq təyin edin
            $table->unsignedBigInteger('product_id')->nullable();

            // Xarici açar təyin edin
            $table->foreign('product_id')->references('Id')->on('product')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('way', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
}
