<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->tinyInteger('offer_type');
            $table->boolean('shipping_condition')->nullable();
            $table->float('minimum_quantity')->nullable();
            $table->float('minimum_spend')->nullable();
            $table->float('maximum_discount')->nullable();
            $table->float('discount_percentage')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('start_time')->nulllable();
            $table->string('expire_time')->nullable();
            $table->tinyInteger('discount_on');
            $table->longText('discount_items')->default('[]');
            $table->tinyInteger('display')->default(1);
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
        Schema::dropIfExists('offers');
    }
}
