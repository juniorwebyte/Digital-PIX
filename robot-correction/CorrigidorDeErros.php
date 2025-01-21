<?php

class CorrigidorDeErros {

    // Função para corrigir erros do Composer
    public function corrigirErrosDoComposer($detalhesDoErro) {
        exec('composer install', $saida, $status); // Tenta rodar o composer install para corrigir dependências
        if ($status === 0) {
            return ['sucesso' => 'Dependências do Composer instaladas ou atualizadas com sucesso.'];
        }
        return ['erro' => 'Falha ao instalar ou atualizar dependências do Composer', 'detalhes' => implode("\n", $saida)];
    }

    // Função para corrigir erros de sintaxe PHP utilizando php-cs-fixer
    public function corrigirErrosDeSintaxePhp($detalhesDoErro) {
        exec('php-cs-fixer fix', $saida, $status); // Corrige erros de sintaxe automaticamente
        if ($status === 0) {
            return ['sucesso' => 'Sintaxe PHP corrigida com sucesso.'];
        }
        return ['erro' => 'Falha ao corrigir erros de sintaxe PHP', 'detalhes' => implode("\n", $saida)];
    }

    // Função para corrigir configurações de rota do Laravel
    public function corrigirRotasLaravel() {
        exec('php artisan route:cache', $saida, $status); // Atualiza o cache de rotas
        if ($status === 0) {
            return ['sucesso' => 'Cache de rotas do Laravel atualizado com sucesso.'];
        }
        return ['erro' => 'Falha ao atualizar o cache de rotas', 'detalhes' => implode("\n", $saida)];
    }

    // Função para corrigir configurações de cache de configuração do Laravel
    public function corrigirCacheConfiguracaoLaravel() {
        exec('php artisan config:cache', $saida, $status); // Atualiza o cache de configurações
        if ($status === 0) {
            return ['sucesso' => 'Cache de configurações do Laravel atualizado com sucesso.'];
        }
        return ['erro' => 'Falha ao atualizar o cache de configurações', 'detalhes' => implode("\n", $saida)];
    }

    // Função para corrigir erros de permissões de arquivos e pastas
    public function corrigirPermissoes() {
        exec('chmod -R 755 storage bootstrap/cache', $saida, $status); // Ajusta as permissões de arquivos
        if ($status === 0) {
            return ['sucesso' => 'Permissões de arquivos corrigidas com sucesso.'];
        }
        return ['erro' => 'Falha ao corrigir permissões de arquivos', 'detalhes' => implode("\n", $saida)];
    }

    // Função para corrigir a assinatura dos métodos report e render no Handler.php
    public function corrigirAssinaturasHandler() {
        $filePath = app_path('Exceptions/Handler.php'); // Caminho para o arquivo Handler.php

        if (!file_exists($filePath)) {
            return ['erro' => 'Arquivo Handler.php não encontrado.'];
        }

        // Lê o conteúdo do arquivo
        $content = file_get_contents($filePath);

        // Atualiza a assinatura dos métodos report e render
        $updatedContent = preg_replace([
            '/public function report\(Exception\s+\$exception\)/',
            '/public function render\(\$request,\s+Exception\s+\$exception\)/'
        ], [
            'public function report(Throwable $exception)',
            'public function render($request, Throwable $exception)'
        ], $content);

        // Verifica se houve alguma alteração
        if ($updatedContent === $content) {
            return ['sucesso' => 'As assinaturas já estão atualizadas.'];
        }

        // Salva o arquivo atualizado
        if (file_put_contents($filePath, $updatedContent)) {
            return ['sucesso' => 'Assinaturas do Handler.php atualizadas com sucesso.'];
        } else {
            return ['erro' => 'Falha ao atualizar o Handler.php.'];
        }
    }

    // Função que corrige erros automaticamente de acordo com os tipos de erro identificados
    public function corrigirErros($erros) {
        $resultados = [];
        foreach ($erros as $erro) {
            // Corrige erros de validação do Composer
            if (strpos($erro['erro'], 'Falha na validação do Composer') !== false) {
                $resultados[] = $this->corrigirErrosDoComposer($erro['detalhes']);
            }
            // Corrige erros de sintaxe PHP
            elseif (strpos($erro['erro'], 'Erros de sintaxe PHP encontrados') !== false) {
                $resultados[] = $this->corrigirErrosDeSintaxePhp($erro['detalhes']);
            }
            // Corrige erros relacionados ao cache de rotas
            elseif (strpos($erro['erro'], 'Erros no cache de rotas') !== false) {
                $resultados[] = $this->corrigirRotasLaravel();
            }
            // Corrige erros relacionados ao cache de configurações
            elseif (strpos($erro['erro'], 'Erros no cache de configurações') !== false) {
                $resultados[] = $this->corrigirCacheConfiguracaoLaravel();
            }
            // Corrige erros de permissões de arquivos
            elseif (strpos($erro['erro'], 'Erro de permissão de arquivos') !== false) {
                $resultados[] = $this->corrigirPermissoes();
            }
            // Corrige assinaturas do Handler.php
            elseif (strpos($erro['erro'], 'Erro nas assinaturas do Handler.php') !== false) {
                $resultados[] = $this->corrigirAssinaturasHandler();
            }
        }
        return $resultados;
    }
}
