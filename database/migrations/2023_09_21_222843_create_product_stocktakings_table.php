<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocktakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocktakings', function (Blueprint $table) {
            $table->increments('id');

            //stocktaking  == so you know what stocktaking does the info belong
            $table->unsignedInteger('stocktaking_id')->unsigned();
            $table->foreign('stocktaking_id')->references('id')->on('stocktakings');

            //drinks == so you about what drink data is about
            $table->unsignedInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('quantity')->nullable()->default(null); 
            $table->double('weight')->nullable()->default(null); // only in GRAMS.
            $table->double('liters')->nullable()->default(null); 
            
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
        Schema::dropIfExists('product_stocktakings');
    }
}
