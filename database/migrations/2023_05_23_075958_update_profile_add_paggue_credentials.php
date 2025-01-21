<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProfileAddPaggueCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consulting_environments', function (Blueprint $table) {
            $table->string('paggue_client_key')->nullable()->after('key_pix_public');
            $table->string('paggue_client_secret')->nullable()->after('key_pix_public');
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
            $table->dropColumn('paggue_client_key');
            $table->dropColumn('paggue_client_secret');
        });
    }
}
