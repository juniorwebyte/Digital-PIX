<?php

// Importação dos arquivos necessários para o robô funcionar
require_once 'ReconhecimentoDeErros.php';
require_once 'CorrigidorDeErros.php';
require_once 'SistemaDeAprendizado.php';
require_once 'Robo.php';

try {
    // Instancia o robô e inicia o processo de execução
    $robo = new Robo();
    
    // Exibe uma mensagem inicial para indicar que o robô está ativo
    echo "Robô iniciado! Preparando para corrigir erros...\n";

    // Executa o robô
    $robo->executar();

    // Exibe uma mensagem de conclusão
    echo "Execução concluída! Verifique os logs para mais detalhes.\n";

} catch (Exception $e) {
    // Tratamento de erros gerais que podem ocorrer durante a execução
    echo "Erro fatal ao executar o robô: " . $e->getMessage() . "\n";
    error_log("Erro fatal: " . $e->getMessage()); // Registra o erro no log para análise futura
}
