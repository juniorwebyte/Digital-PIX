<?php

class SistemaDeAprendizado {
    private $arquivoDeLog = 'logs/log_de_erros.json';

    public function __construct() {
        // Cria a pasta de logs se ela não existir
        if (!file_exists('logs')) {
            mkdir('logs', 0777, true);
        }
    }

    /**
     * Registra um erro no log de erros.
     *
     * @param array $erro Dados do erro encontrado.
     */
    public function registrarErro($erro) {
        $log = $this->obterLog();
        $log[] = $erro;
        file_put_contents($this->arquivoDeLog, json_encode($log, JSON_PRETTY_PRINT));
    }

    /**
     * Obtém todos os erros registrados no log.
     *
     * @return array Lista de erros registrados.
     */
    public function obterLog() {
        return file_exists($this->arquivoDeLog) ? json_decode(file_get_contents($this->arquivoDeLog), true) : [];
    }

    /**
     * Analisa os logs para identificar padrões e melhorar estratégias de correção.
     */
    public function aprenderComOLog() {
        $log = $this->obterLog();

        if (empty($log)) {
            echo "Nenhum dado no log para aprendizado.\n";
            return;
        }

        // Exemplo de análise de padrões
        $padroesDeErros = [];
        foreach ($log as $erro) {
            $tipo = $erro['erro'] ?? 'desconhecido';
            if (!isset($padroesDeErros[$tipo])) {
                $padroesDeErros[$tipo] = 0;
            }
            $padroesDeErros[$tipo]++;
        }

        echo "Padrões de Erros Identificados:\n";
        foreach ($padroesDeErros as $tipo => $frequencia) {
            echo "- Tipo: $tipo | Frequência: $frequencia\n";
        }

        // Sugestão de melhorias futuras: salvar os padrões aprendidos para otimizar as correções.
    }

    /**
     * Atualiza o sistema de aprendizado com novos erros e resultados.
     *
     * @param array $erros Lista de erros encontrados.
     * @param array $resultados Resultados das tentativas de correção.
     */
    public function atualizarConhecimento($erros, $resultados) {
        foreach ($erros as $index => $erro) {
            $resultado = $resultados[$index] ?? null;
            $registro = [
                'erro' => $erro['erro'] ?? 'desconhecido',
                'detalhes' => $erro['detalhes'] ?? 'sem detalhes',
                'resultado' => $resultado,
                'timestamp' => date('Y-m-d H:i:s'),
            ];
            $this->registrarErro($registro);
        }
    }
}
