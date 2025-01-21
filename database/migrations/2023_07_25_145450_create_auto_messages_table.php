<?php

use App\AutoMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificador');
            $table->string('descricao');
            $table->string('destinatario');
            $table->longText('msg')->default('');
            $table->timestamps();
        });

        AutoMessage::create([
            'identificador' => 'compra-admin',
            'descricao' => 'Compra Realizada',
            'destinatario' => 'admin'
        ]);

        AutoMessage::create([
            'identificador' => 'compra-cliente',
            'descricao' => 'Compra Realizada',
            'destinatario' => 'cliente'
        ]);

        AutoMessage::create([
            'identificador' => 'recebido-admin',
            'descricao' => 'Pagamento Confirmado',
            'destinatario' => 'admin'
        ]);

        AutoMessage::create([
            'identificador' => 'recebido-cliente',
            'descricao' => 'Pagamento Confirmado',
            'destinatario' => 'cliente'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_messages');
    }
}
