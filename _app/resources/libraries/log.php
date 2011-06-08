<?php

class log extends config {

    /**
     |
     |   * Nome dos principais erros no PHP.
     |
     |   * @private string - valores em array unidirecional.
     |
     */

    private $erros_costants = array (
                E_COMPILE_ERROR => 'COMPILE ERROR',
                E_COMPILE_WARNING => 'COMPILE WARNING',
                E_CORE_ERROR => 'CORE ERROR',
                E_CORE_WARNING => 'CORE WARNING',
                E_ERROR => 'ERROR',
                E_NOTICE => 'NOTICE',
                E_PARSE => 'PARSING ERROR',
                E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
                E_STRICT => 'STRICT NOTICE',
                E_USER_ERROR => 'USER ERROR',
                E_USER_WARNING => 'USER WARNING',
                E_USER_NOTICE => 'USER NOTICE',
                E_WARNING => 'WARNING'
            );

    /*
    |---------------------------------------------------------------------------
    |   Funчуo para gerenciamento de erros e logs.
    |---------------------------------------------------------------------------
    |
    |   * Manipulaчуo de erros, criando resultados e historicos mais agradavщis
    |     ao administrador, podendo consultar em um arquivo local.
    |
    |   * @param string errno    - nome do erro.
    |   * @param string errstr   - descriчуo do erro.
    |   * @param string errfile  - arquivo onde se localiza o erro.
    |   * @param string errline  - linha do erro.
    |
    */

    public function log_error($errno, $errstr, $errfile, $errline) {

        # carrengando template do arquivo.
        $template = new template(TEMPLATES_PATH_RESOURCE . "error.php");

        # variavщis do template.
        $template->DATA      = date('d/m/Y');
        $template->HORA      = date('H:i:s');

        $template->NOME      = $this->erros_costants[$errno];
        $template->FILE      = $errfile;
        $template->LINHA     = $errline;
        $template->DESCRICAO = $errstr;

        $template->IP        = $_SERVER['REMOTE_ADDR'];
        $template->USER      = $_SERVER['HTTP_USER_AGENT'];
        $template->LOCAL     = $_SERVER['HTTP_HOST'];

        // Registrando dados em arquivo.
        $log = $template->parse();
        file_put_contents(ERROR_FILE, $log, FILE_APPEND);

    }
}

?>