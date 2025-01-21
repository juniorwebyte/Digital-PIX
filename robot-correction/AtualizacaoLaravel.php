<?php

class AtualizacaoLaravel {

    /**
     * Atualiza o Laravel para a versão mais recente.
     */
    public function atualizarLaravel() {
        // Verifica a versão atual do Laravel
        exec('php artisan --version', $saida, $status);
        $versaoAtual = $status === 0 ? implode("\n", $saida) : 'Desconhecida';
        
        echo "Versão atual do Laravel: $versaoAtual\n";
        
        // Atualiza o Laravel para a versão mais recente
        exec('composer update', $saida, $status);
        if ($status === 0) {
            echo "Laravel atualizado com sucesso!\n";
        } else {
            echo "Erro ao atualizar o Laravel: " . implode("\n", $saida) . "\n";
        }
    }
}
