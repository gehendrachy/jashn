<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnRouteProductSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_route_product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('on_route_id')->constrained('on_routes')->onDelete('cascade');
            $table->foreignId('product_size_id')->constrained('product_sizes')->onDelete('cascade');
            $table->integer('quantity');
            $table->tinyInteger('status')->default(2);
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
        Schema::dropIfExists('on_route_product_sizes');
    }
}
