<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateParticipanteAddNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participant', function (Blueprint $table) {
            $table->longText('numbers')->nullable()->after('valor');
            $table->integer('reservados')->default(0)->after('numbers');
            $table->integer('pagos')->default(0)->after('numbers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participant', function (Blueprint $table) {
            $table->dropColumn('numbers');
            $table->dropColumn('reservados');
            $table->dropColumn('pagos');
        });
    }
}
