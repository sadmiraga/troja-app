<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');

            $table->string('supplier')->nullable();

            $table->boolean('completed')->default(false);
            $table->timestamp('start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end')->nullable();

            $table->boolean('updated');
            $table->timestamp('update_start')->nullable();
            $table->timestamp('update_end')->nullable();

            //location
            $table->unsignedInteger('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            //user
            $table->unsignedInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 

            //needing list
            $table->unsignedInteger('needing_id')->unsigned()->nullable();
            $table->foreign('needing_id')->references('id')->on('needings')->onDelete('cascade'); 

            $table->string('storage')->nullable();

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
        Schema::dropIfExists('deliveries');
    }
}
