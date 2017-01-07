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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('model')->nullable();
            $table->float('price', 8, 2);
            $table->integer('stock_qty')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('name', 'index_name');
            $table->index('model', 'index_model');
            $table->index('stock_qty', 'index_stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
