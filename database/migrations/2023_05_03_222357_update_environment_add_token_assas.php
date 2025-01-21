<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnvironmentAddTokenAssas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consulting_environments', function (Blueprint $table) {
            $table->string('token_asaas')->nullable()->after('key_pix_public');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consulting_environments', function (Blueprint $table) {
            $table->dropColumn('token_asaas');
        });
    }
}
