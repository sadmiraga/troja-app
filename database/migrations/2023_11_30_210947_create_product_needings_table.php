<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductNeedingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_needings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('needing_id')->unsigned();
            $table->foreign('needing_id')->references('id')->on('needings')->onDelete('cascade');

            $table->unsignedInteger('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('quantity')->nullable()->default(null);
            $table->double('weight')->nullable()->default(null);
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
        Schema::dropIfExists('product_needings');
    }
}
