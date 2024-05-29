<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_color_id')->constrained()->onDelete('cascade');
            $table->foreignId('size_id')->constrained()->onDelete('cascade');
            $table->boolean('display')->default(1);
            $table->integer('quantity');
            $table->float('price');
            $table->float('offer_price')->nullable();
            $table->string('sku');
            $table->boolean('preorder')->default(0);
            $table->integer('preorder_stock_limit')->nullable();
            $table->float('preorder_price')->nullable();
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
        Schema::dropIfExists('product_sizes');
    }

    public function product_color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    // public function product(){
    //     return $this->belongsTo(Product::class, ProductColor::class, 'product_id', 'product_color_id')
    // }
}
