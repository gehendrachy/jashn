<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedProductDiscountCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_product_discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordered_product_id')->constrained('ordered_products')->onDelete('cascade');
            $table->foreignId('discount_coupon_id')->constrained('discount_coupons')->onDelete('cascade');
            $table->float('discount_amount');
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
        Schema::dropIfExists('ordered_product_discount_coupons');
    }
}
