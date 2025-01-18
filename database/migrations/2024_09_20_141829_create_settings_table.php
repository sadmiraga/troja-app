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

            //style
            $table->string('logo');
            $table->string('favicon')->nullable();

            //settings
            $table->boolean('multiple_locations')->default(false);
            $table->boolean('weekly_menus')->default(false);
            $table->boolean('food_enabled')->default(true);
            $table->boolean('drink_enabled')->default(true);
            $table->boolean('extra_categories_enabled')->default(false);
            $table->boolean('deliveries_enabled')->default(false);
            $table->boolean('needing_list_enabled')->default(false);

            $table->boolean('has_restaurant')->default(false);
            

            //collors
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('tertiary_color')->nullable();
            $table->string('accent_color')->nullable();
            $table->string('accent_opacity_color')->nullable();
            $table->string('light_color')->nullable();
            $table->string('dark_color')->nullable();


            //LINKS
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('google_review_link')->nullable();


            


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
