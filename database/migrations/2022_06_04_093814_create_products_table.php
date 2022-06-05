<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigincrements('id');
            $table->string('name')->nullable();
            $table->string('product_code')->nullable();

            $table->integer('category_id')->nullable();
            $table->integer('qty');

            $table->string('image_url1');
            $table->string('image_url2')->nullable();
            
            
            $table->string('description')->nullable();
            $table->string('remark')->nullable();

            $table->integer('additional_charges')->nullable();
            $table->integer('sale_price')->nullable();

            $table->integer('status')->default(1);

            $table->string('GST')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('products');
    }
}
