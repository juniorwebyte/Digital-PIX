<?php

class ComposerAtualizacao {

    /**
     * Atualiza as dependências do Composer.
     */
    public function atualizarDependencias() {
        // Atualiza as dependências do Composer
        exec('composer install', $saida, $status);
        if ($status === 0) {
            echo "Dependências do Composer atualizadas com sucesso!\n";
        } else {
            echo "Erro ao atualizar as dependências do Composer: " . implode("\n", $saida) . "\n";
        }

        // Verifica se as dependências estão corretamente carregadas
        exec('composer dump-autoload', $saida, $status);
        if ($status === 0) {
            echo "Autoload do Composer regenerado com sucesso!\n";
        } else {
            echo "Erro ao gerar o autoload do Composer: " . implode("\n", $saida) . "\n";
        }
    }
}
