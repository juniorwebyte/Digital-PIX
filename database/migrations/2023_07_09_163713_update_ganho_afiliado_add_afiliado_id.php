<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGanhoAfiliadoAddAfiliadoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ganhos_afiliados', function (Blueprint $table) {
            $table->integer('afiliado_id')->nullable()->unsigned()->after('participante_id');

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
        Schema::table('ganhos_afiliados', function (Blueprint $table) {
            $table->dropColumn('afiliado_id');
        });
    }
}
