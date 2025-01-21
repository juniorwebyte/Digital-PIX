<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGanhosAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ganhos_afiliados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->nullable()->unsigned();
            $table->integer('participante_id')->nullable()->unsigned();
            $table->float('valor', 8, 2);
            $table->boolean('pago')->default(0);
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('participante_id')->references('id')->on('participant')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ganhos_afiliados');
    }
}
