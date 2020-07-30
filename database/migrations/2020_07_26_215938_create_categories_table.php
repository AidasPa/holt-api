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
            $table->id();

            $table->string('title')->index();
            $table->text('image')->nullable();
            $table->string('image_blurhash')->nullable();

            $table->timestamps();
        });

        Schema::create('category_restaurant', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('restaurant_id');

            $table->unique(['category_id', 'restaurant_id']);

            $table->foreign('restaurant_id')
                ->references('id')
                ->on('restaurants')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');


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
