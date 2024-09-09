<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeedingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('needings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('storage'); // bar / restaurant
            $table->boolean('completed');
            $table->string('confirmed_status'); // not_confirmed - in_progress - confirmed

            $table->string('method')->nullable(); // scale - paper
            $table->string('unit')->nullable(); //kg - g 

            $table->unsignedInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            $table->timestamp('updated_end_time')->nullable();

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
        Schema::dropIfExists('needings');
    }
}
