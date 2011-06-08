<?php

/*  Principais caminhos e arquivos do sistema. */

defined("LIBRARIES_PATH")
        or define("LIBRARIES_PATH",
                realpath(dirname(__FILE__) . '/../libraries/'));

defined("ADMIN_STRUCTURE_LOCAL")
        or define("ADMIN_STRUCTURE_LOCAL",
                realpath(dirname(__FILE__) . '/../../../admin/_structure/'));

defined("ADMIN_TEMPLATES_PATH")
        or define("ADMIN_TEMPLATES_PATH",
                realpath(dirname(__FILE__) . '/../../../admin/_template/'));

defined("TEMPLATES_PATH")
        or define("TEMPLATES_PATH",
                realpath(dirname(__FILE__) . '/../../../_template/'));

defined("ERROR_FILE")
        or define("ERROR_FILE",
                realpath(dirname(__FILE__) . '/../logs/error.txt'));

/**
 * Carregar configuraчѕes
 *
 * Todas as configuraчѕes necessarias para o uso da biblioteca e de
 * conexѕes com banco de dados e dados externos.
 */

require_once(realpath(dirname(__FILE__) . "/../config/config.php")); $config = new config();

/**
 * Carregar conexуo com o banco de dados
 *
 * Todas as configuraчѕes necessarias para o uso da biblioteca e de
 * conexѕes com banco de dados e dados externos.
 */

require_once(realpath(dirname(__FILE__) . "/../config/database.php"));

/**
 * Funчуo de auto-carregamento
 *
 * Funчуo para auto carregamento de conteњdos e bibliotecas, assim como
 * criaчуo de paths(caminhos), mais acessiveis.
 */

function __autoload($library) {
    require_once(LIBRARIES_PATH . "/" . $library . '.php');
}

/**
 * Manipular erros e logs.
 *
 * Funчуo que oculta possэveis erros no sistema e o exibir de forma mais
 * agradсvel para o administrador do sistema em arquivos log e(ou) email.
 */

#$log_error = new log();
#set_error_handler(array(&$log_error, 'log_error'));
