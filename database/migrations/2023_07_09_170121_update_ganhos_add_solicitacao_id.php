<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGanhosAddSolicitacaoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ganhos_afiliados', function (Blueprint $table) {
            $table->integer('solicitacao_id')->nullable()->unsigned()->after('participante_id');

            // $table->foreign('solicitacao_id')->references('id')->on('solicitacao_afiliados')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ganhos_afiliados', function (Blueprint $table) {
            $table->dropColumn('solicitacao_id');
        });
    }
}
