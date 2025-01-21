<?php

class EditorDeCodigo {

    /**
     * Abre um editor de código para edição.
     *
     * @param string $arquivo Caminho do arquivo que será editado.
     */
    public function editarArquivo($arquivo) {
        // Exemplo: Abre o VSCode com o arquivo especificado
        exec("code $arquivo");
    }

    /**
     * Refatora o código do arquivo para seguir as boas práticas de PSR.
     *
     * @param string $arquivo Caminho do arquivo que será refatorado.
     */
    public function refatorarCodigo($arquivo) {
        // Refatoração com PHP_CodeSniffer ou php-cs-fixer
        exec("php-cs-fixer fix $arquivo --rules=@PSR12");
    }
}
