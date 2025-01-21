<?php

// Defina o caminho do seu diretório de trabalho Laravel
$projectDirectory = __DIR__; // Ou defina o caminho exato, caso não esteja no mesmo diretório do projeto

// Função para rodar comandos no terminal
function runCommand($command, $workingDirectory = null) {
    echo "Executando: $command\n";
    $output = shell_exec($command);
    echo $output;
    return $output;
}

// Função para verificar se há erro na execução do comando
function checkCommandError($output) {
    return strpos($output, 'error') !== false || strpos($output, 'Exception') !== false;
}

// Função para corrigir problemas comuns de dependência ou configuração
function fixCommonIssues($output) {
    $fixed = false;

    // Corrigir erro de dependências
    if (strpos($output, 'Your requirements could not be resolved') !== false) {
        echo "Detectado erro de dependências. Tentando corrigir...\n";
        $fixed = runCommand('composer install', __DIR__) !== '';
    }

    // Corrigir problemas de autoload
    if (strpos($output, 'php artisan') !== false && strpos($output, 'Class not found') !== false) {
        echo "Erro de classe não encontrada. Tentando otimizar autoload...\n";
        $fixed = runCommand('composer dump-autoload', __DIR__) !== '';
    }

    // Corrigir problemas de configuração .env
    if (strpos($output, '.env') !== false) {
        echo "Corrigindo configurações do .env...\n";
        if (!file_exists('.env')) {
            echo "Criando arquivo .env...\n";
            copy('.env.example', '.env');
        }
        $fixed = true;
    }

    return $fixed;
}

// Função para otimizar o Laravel
function optimizeLaravel() {
    echo "Otimização do Laravel...\n";
    runCommand('php artisan optimize', __DIR__);
}

// Função para rodar migrações automaticamente
function runMigrations() {
    echo "Rodando migrações...\n";
    runCommand('php artisan migrate --force', __DIR__);
}

// Função para limpar caches
function clearCaches() {
    echo "Limpando caches...\n";
    runCommand('php artisan config:clear', __DIR__);
    runCommand('php artisan cache:clear', __DIR__);
    runCommand('php artisan route:clear', __DIR__);
    runCommand('php artisan view:clear', __DIR__);
}

// Função para atualizar pacotes
function updatePackages() {
    echo "Atualizando pacotes...\n";
    $output = runCommand('composer update', __DIR__);
    if (checkCommandError($output)) {
        echo "Erro ao tentar atualizar pacotes. Corrigindo...\n";
        $fixed = fixCommonIssues($output);
        if (!$fixed) {
            echo "Erro não corrigido automaticamente. Relatório necessário: \n";
            echo $output . "\n";
        }
    }
}

// Função principal para executar as correções e atualizações
function updateLaravel() {
    echo "Iniciando atualização do Laravel...\n";

    $startTime = microtime(true);

    // Passo 1: Atualizar pacotes e dependências
    updatePackages();

    // Passo 2: Limpar caches e otimizar
    clearCaches();
    optimizeLaravel();

    // Passo 3: Rodar migrações
    runMigrations();

    // Passo 4: Garantir a atualização das rotas
    echo "Atualizando rotas...\n";
    runCommand('php artisan route:cache', __DIR__);

    // Passo 5: Garantir que o autoload está correto
    echo "Atualizando autoload...\n";
    runCommand('composer dump-autoload', __DIR__);

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    echo "Atualização completa e automatizada do Laravel com sucesso!\n";
    echo "Tempo total de execução: " . round($executionTime, 2) . " segundos\n";
}

// Chamar a função para iniciar o processo de atualização
updateLaravel();