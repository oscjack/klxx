<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->float('total', 10, 2)->unsigned();
            $table->float('paid', 10, 2)->unsigned();
            $table->text('description')->nullable();
            $table->enum('status', [
                'pending',
                'paid',
                'sending',
                'received'
            ]);
            $table->timestamps();

            $table->index('customer_id', 'customer_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
