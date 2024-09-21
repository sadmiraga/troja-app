<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('logo');

            $table->boolean('multiple_locations')->default(false);
            $table->boolean('weekly_menus')->default(false);
            $table->boolean('food_enabled')->default(true);
            $table->boolean('drink_enabled')->default(true);

            //collors
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('tertiary_color')->nullable();
            $table->string('accent_color')->nullable();
            $table->string('accent_opacity_color')->nullable();
            $table->string('light_color')->nullable();
            $table->string('dark_color')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
