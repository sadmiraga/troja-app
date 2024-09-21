<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->increments('id');

            $table->string('categoryName');
            $table->string('drink_or_food');

            $table->integer('position')->nullable();

            $table->unsignedInteger('location_id')->unsigned()->nullable();;
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            $table->text('icon')->nullable();

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
        Schema::dropIfExists('categories');
    }
}
