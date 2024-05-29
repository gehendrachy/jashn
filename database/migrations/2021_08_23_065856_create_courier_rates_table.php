<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->foreignId('state_id')->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->float('half_kg')->nullable();
            $table->float('one_kg')->nullable();
            $table->float('one_half_kg')->nullable();
            $table->float('two_kg')->nullable();
            $table->float('two_half_kg')->nullable();
            $table->float('three_kg')->nullable();
            $table->float('three_half_kg')->nullable();
            $table->float('four_kg')->nullable();
            $table->float('four_half_kg')->nullable();
            $table->float('five_kg')->nullable();
            $table->float('per_500g')->nullable();
            $table->boolean('display')->default(1);
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
        Schema::dropIfExists('courier_rates');
    }
}
