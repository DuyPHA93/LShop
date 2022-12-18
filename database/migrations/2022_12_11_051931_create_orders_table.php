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
            $table->bigIncrements('id');
            $table->string('order_no');
            $table->date('order_date');
            $table->integer('person_order_id');
            $table->string('contact_first_name');
            $table->string('contact_last_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('contact_address');
            $table->string('note')->nullable();
            $table->string('status');
            $table->string('reason_for_cancel_order')->nullable();
            $table->integer('total_quantity');
            $table->decimal('total_price', 13, 2);
            $table->string('warehouse_pickup')->nullable();
            $table->string('shipping_code')->nullable();
            $table->string('transporter')->nullable();
            $table->string('shipping_status')->nullable();
            $table->decimal('total_weight', 10, 2)->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('receive_order_date')->nullable();
            $table->date('confirm_complete_order_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
