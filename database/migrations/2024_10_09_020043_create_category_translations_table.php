<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_translations', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->nullable();

            // language id 
            $table->unsignedInteger('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            // menu item id 
            $table->unsignedInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

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
        Schema::dropIfExists('category_translations');
    }
}
