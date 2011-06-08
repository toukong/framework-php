<?php

# Arquivos necessários.
require_once(realpath(dirname(__FILE__) . "/_app/resources/config/autoload.php"));
require_once(realpath(dirname(__FILE__) . "/_app/resources/config/database.php"));

# Helpers.

# Biblioteca de Segurança.
$secury = new secury();

# Caso haja pedido de login inicia verificação de usuário.
if($_POST)
{

        # Classe de banco de dados .
        $db = new database(); $db->connect();

        # Recebe valores a serem confirmados.
        $user = mysql_real_escape_string($_POST["user"]);
        $pass = mysql_real_escape_string($_POST["pass"]);

        # Função para conexão do usuário.
        $access = $secury->user_login($user, $pass); session_start();

        /* Atributos adicionais para a sessão */
        $_SESSION["language"] = 1;

        # Redirecionar
        if($access)
        {
            # Permitido acesso.
            header("Location: /admin/content/manager"); exit;
        }
        else
        {
            # Acesso negado.
            header("Location: /login"); exit;
        }

}

# Carrengando template do arquivo.
$view = new template(ADMIN_TEMPLATES_PATH . "/login.html");

# Imprimir conteúdo.
$view->show();

?>
