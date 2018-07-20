<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('serial_number');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->longText('name');
            $table->longText('purchase_price');
            $table->longText('selling_price');
            $table->longText('note');
            $table->integer('stock_quantity');
            $table->binary('image');
            $table->integer('status');
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
        Schema::dropIfExists('product');
    }
}
