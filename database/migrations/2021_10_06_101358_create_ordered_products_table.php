<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_products', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->constrained();
            $table->integer('product_id');
            $table->string('product_title');
            $table->float('product_price');
            $table->boolean('preorder_status')->default(0);
            $table->integer('product_color_id');
            $table->integer('color_id');
            $table->string('color_name')->nullable();
            $table->string('color_code')->nullable();
            $table->integer('product_size_id');
            $table->integer('size_id');
            $table->string('size_name')->nullable();
            $table->integer('quantity');
            $table->float('sub_total');
            $table->tinyInteger('status')->default(0);
            $table->text('remarks')->nullable();
            $table->float('weight')->nullable();
            $table->tinyInteger('has_free_shipping')->nullable();
            $table->tinyInteger('is_shipped')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('ordered_products');
    }
}
