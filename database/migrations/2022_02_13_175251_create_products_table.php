<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('price');
            $table->string('status');
            $table->integer('qtd')->nullable();
            $table->integer('processado')->default(0);
            $table->string('type_raffles');
            $table->boolean('favoritar');
            $table->string('modo_de_jogo');
            $table->integer('minimo');
            $table->integer('maximo');
            $table->integer('user_id')->unsigned();
            $table->dateTime('draw_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
