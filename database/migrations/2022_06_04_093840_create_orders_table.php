<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('invoice_id');
            $table->date('order_date');

            $table->integer('user_id');
            $table->string('customer_name')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->integer('total_qty');
            $table->float('cart_total')->nullable();
            $table->integer('promo_code_id')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('final_cost')->nullable();

            $table->integer('transaction_id')->nullable();
            $table->string('payment_ss')->nullable();

            $table->integer('status')->default(1);

            $table->integer('created_by')->default(4);
            $table->integer('updated_by')->nullable();
            
            $table->text('remark')->nullable();


            $table->timestamps();
            $table->softDeletes();

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
