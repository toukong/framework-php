<?php

class config {

   /**
    |--------------------------------------------------------------------------
    |   Conexao com o banco de dados.
    |--------------------------------------------------------------------------
    |
    |   * Valores necessarios para estabelecer a conexao com o serividor MySQL,
    |     podendo inserir multiplas bases.
    |
    */

   protected    $db = array(
                    1 => array(
                            "host" => "localhost",
                            "user" => "root",
                            "pass" => "",
                            "data" => "framework"
                    )
                );

   /**
    |--------------------------------------------------------------------------
    |   URL´s predefinidas.
    |--------------------------------------------------------------------------
    |
    |   * Caminhos na web predefinadas para uso no sistema, podem ser consultas
    |     em JSON, XML, consultar dados diversos de fonte externa.
    |
    */

    public      $url = array(
                    "base"   => "http://localhost/",
                    "page"   => "http://localhost/",
                    "admin"  => "http://localhost/admin/dashboard",
                    "login"  => "http://localhost/admin?cmd=login"
                );

   /**
    |--------------------------------------------------------------------------
    |   Email´s.
    |--------------------------------------------------------------------------
    |
    |   * Escolha de email predefinidos para usos diversos que vão desde
    |     recebimento de logs de error até ao envio do formularios de contato.
    |
    */

    public      $email = array(
                    1 => "leandroeros.developer@gmail.com",
                    2 => "hello@leandroeros.com"
                );

   /**
    |--------------------------------------------------------------------------
    |   Chave criptográfica.
    |--------------------------------------------------------------------------
    |
    |   * String para otimilizar a criptográfia de dados em md5() e sha1().
    |
    */

    protected   $encryption_key = "";
    
}

   /**
    |--------------------------------------------------------------------------
    |   Horario Regional - Timezone.
    |--------------------------------------------------------------------------
    |
    |   * O uso de datas pede a confirmação do horario local.
    |
    */

    date_default_timezone_set("America/Fortaleza");

?>