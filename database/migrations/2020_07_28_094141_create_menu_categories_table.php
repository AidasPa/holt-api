<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->unique(['title', 'restaurant_id']);

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
        Schema::dropIfExists('menu_categories');
    }
}
