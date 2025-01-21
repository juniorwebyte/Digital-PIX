<?php

class ReconhecimentoDeErros {
    /**
     * Verifica erros relacionados ao Composer.
     *
     * @return array|null Retorna detalhes do erro ou null se nenhum erro for encontrado.
     */
    public function verificarErrosDoComposer() {
        // Executa a validação do Composer
        exec('composer validate --no-check-all', $saida, $status);
        if ($status !== 0) {
            return [
                'erro' => 'Falha na validação do Composer',
                'detalhes' => implode("\n", $saida)
            ];
        }
        return null;
    }

    /**
     * Verifica erros de sintaxe nos arquivos PHP.
     *
     * @return array|null Retorna detalhes do erro ou null se nenhum erro for encontrado.
     */
    public function verificarErrosDeSintaxePhp() {
        // Verifica sintaxe PHP em todos os arquivos do projeto
        exec('find . -type f -name "*.php" -exec php -l {} \;', $saida, $status);
        if ($status !== 0) {
            return [
                'erro' => 'Erros de sintaxe PHP encontrados',
                'detalhes' => implode("\n", $saida)
            ];
        }
        return null;
    }

    /**
     * Verifica se há arquivos ausentes ou incorretos no autoload do Composer.
     *
     * @return array|null Retorna detalhes do erro ou null se nenhum erro for encontrado.
     */
    public function verificarAutoloadDoComposer() {
        // Tenta reconstruir o autoload
        exec('composer dump-autoload', $saida, $status);
        if ($status !== 0) {
            return [
                'erro' => 'Erro ao gerar o autoload do Composer',
                'detalhes' => implode("\n", $saida)
            ];
        }
        return null;
    }

    /**
     * Verifica arquivos de configuração padrão do Laravel.
     *
     * @return array|null Retorna detalhes do erro ou null se nenhum erro for encontrado.
     */
    public function verificarConfiguracoesLaravel() {
        // Checa problemas na configuração
        exec('php artisan config:cache', $saida, $status);
        if ($status !== 0) {
            return [
                'erro' => 'Erro nas configurações do Laravel',
                'detalhes' => implode("\n", $saida)
            ];
        }
        return null;
    }

    /**
     * Agrega todas as verificações de erros em uma lista.
     *
     * @return array Lista de erros encontrados.
     */
    public function obterErros() {
        $erros = [];

        // Verificar cada tipo de erro
        $verificadores = [
            'verificarErrosDoComposer',
            'verificarErrosDeSintaxePhp',
            'verificarAutoloadDoComposer',
            'verificarConfiguracoesLaravel'
        ];

        foreach ($verificadores as $verificador) {
            try {
                $erro = $this->$verificador();
                if ($erro) {
                    $erros[] = $erro;
                }
            } catch (Exception $e) {
                $erros[] = [
                    'erro' => 'Erro ao executar ' . $verificador,
                    'detalhes' => $e->getMessage()
                ];
            }
        }

        return $erros;
    }
}
