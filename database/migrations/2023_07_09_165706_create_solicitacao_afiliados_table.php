<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacaoAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacao_afiliados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('afiliado_id')->nullable()->unsigned();
            $table->boolean('pago')->default(0);
            $table->timestamps();
            
            $table->foreign('afiliado_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitacao_afiliados');
    }
}
