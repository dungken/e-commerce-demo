<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedInteger('price');
            $table->text('desc', 500)->nullable();
            $table->string('thumbnail', 300);
            $table->text('detail', 3000);
            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('product_cats')->onDelete('cascade');
            $table->softDeletes();
            $table->enum('status', ['soldOut', 'inStock']);
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
        Schema::dropIfExists('products');
    }
}
