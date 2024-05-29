<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRequestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_request_products', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('return_request_no');
            $table->foreignId('ordered_product_id');
            $table->integer('product_id');
            $table->integer('product_color_id');
            $table->integer('product_size_id');
            $table->float('weight')->nullable();
            $table->integer('quantity');
            $table->float('sub_total');
            $table->string('reason')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_request_products');
    }
}
