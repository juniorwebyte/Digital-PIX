<?php

class IAConector {

    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Conecta-se à API do GPT-4 para obter sugestões de código ou correções.
     *
     * @param string $codigo O código que precisa de correção ou sugestão.
     * @return string A sugestão ou correção recebida da API.
     */
    public function obterSugestaoDeCodigo($codigo) {
        $url = "https://api.openai.com/v1/completions";
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->apiKey
        ];
        $data = [
            'model' => 'gpt-4',
            'prompt' => "Corrija o seguinte código PHP:\n$codigo",
            'max_tokens' => 150
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        return $responseData['choices'][0]['text'] ?? '';
    }
}
