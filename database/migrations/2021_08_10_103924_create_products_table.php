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
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained();
            $table->boolean('display')->default(1);
            $table->boolean('featured')->default(0);
            $table->boolean('stock_status')->default(1);
            $table->float('price')->nullable();
            $table->float('offer_price')->nullable();
            $table->string('gender');
            $table->text('highlights')->nullable();
            $table->text('description')->nullable();
            // $table->foreignId('color_id')->constrained();
            $table->string('image')->nullable();
            $table->string('video_link')->nullable();
            $table->integer('size_guide_id')->nullable();
            $table->integer('size_group_id');
            $table->boolean('warranty')->default(0);
            $table->float('weight')->default(0);
            $table->float('product_cares')->default('[]');
            $table->integer('views')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
