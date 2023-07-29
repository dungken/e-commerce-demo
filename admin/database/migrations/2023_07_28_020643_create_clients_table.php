<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code_order', 11);
            $table->string('code_client', 11);
            $table->string('name', 50);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->string('address', 200);
            $table->string('note', 500)->nullable();
            $table->enum('payment', ['home', 'direct']);
            $table->enum('status', ['pending', 'approved', 'delivering', 'received', 'paid']);
            $table->unsignedInteger('num_order');
            $table->unsignedBigInteger('total');
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
        Schema::dropIfExists('clients');
    }
}
