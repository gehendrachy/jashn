<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->constrained();
            $table->foreignId('size_id')->constrained();
            $table->boolean('display')->default(1);
            $table->integer('quantity');
            $table->float('price')->nullable();
            $table->float('offer_price')->nullable();
            $table->string('sku')->nullable();
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
        Schema::dropIfExists('product_variations');
    }
}
