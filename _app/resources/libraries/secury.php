<?php

class secury extends database {

    private $db_user = "user";

    private $url_logout = "/login";

    /**
     * Criptografar valores em MD5.
     *
     * A função criptografa valores em uma mão(não há como descriptografar),
     * também inclui uma chave ao valor a ser criptografado e assim
     * dificultando tentativas repetitivas.
     *
     * @param string $value - valor a ser criptografado em MD5.
     * @return md5.
     */

    public function encryption($value) {
        return md5($value . $this->encryption_key);
    }

    /**
     * Login de usuários por nivel
     *
     * Função que verifica os dados de usuario e senha criptografando junto
     * a chave em MD5 e por fim caso exista somente 1 usuário, o inicia em
     * uma sessão que deve ser mantida até o logout.
     *
     * @param  string  $user - identificador unico do usuário.
     * @param  string  $pass - senha a ser conferido com a existente.
     *
     * @return boolean.
     */

    public function user_login($user, $pass) {

        # consultando no banco de dados pelo usuário.
        $sql  = "SELECT `id`, `name`, `nivel` FROM `". $this->db_user ."` ";

        # campos a serem exatamente confirmados.
        $sql .= "WHERE (`user` = '". $user ."') ";
        $sql .= "AND   (`pass` = '". $this->encryption($pass) ."') ";
        $sql .= "LIMIT 1";

        $query = mysql_query($sql);

        if (mysql_num_rows($query) != 1)
        {
            # nenhum usuário foi encontrado.
            return false;
        } 
        else
        {
            # iniciar uma sessão caso não exista uma.
            if (!isset($_SESSION)) session_start();

            # salvar valores diretamente na sessão.
            $_SESSION = mysql_fetch_assoc($query);

            # usuário confirmado.
            return true;
        }

    }

    /**
     * Confirmar identificação
     *
     * Confirma existência de Cookies criados no login, caso não haja
     * e ou por consequencia o usuário não tenha nivel suficiente, retorna
     * para logout.
     *
     * @param  int  $nivel - Nivel necessário na pagina.
     *
     * @return boolean.
     */

    public function user_confirm($header=true, $nivel=1) {

        # iniciando sessão.
        if(!isset($_SESSION)) session_start();

        # verificando a existência do usuário.
        if (!isset($_SESSION['id']) OR ($_SESSION['nivel']) < $nivel)
        {
            if($header)
            {
                # retornar o usuário a tela de login.
                header("Location: " . $this->url_logout); exit;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }

    /**
     * Confirmar identificação
     *
     * Confirma existência de Cookies criados no login, caso não haja
     * e ou por consequencia o usuário não tenha nivel suficiente, retorna
     * para logout.
     *
     * @param  int  $nivel - Nivel necessário na pagina.
     *
     * @return boolean.
     */

    public function logout() {

        if(session_start()) {
            session_destroy();
        }

        $this->close();

        header("Location: " . $this->url_logout); exit;
    }

    /**
     * Ìndices Textuais.
     *
     * Traduz qualquer número (até 9.007.199.254.740.992), a funcão é
     * baseada nos links de id textual usado no YouTube, são utéis, bonitos
     * e trazem mais segurança.
     *
     * Exemplo (Numero -> Texto): 9007199254740989 --> PpQXn7COf
     *
     * @author    Kevin van Zonneveld <kevin@vanzonneveld.net>
     * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
     * @license   http://www.opensource.org/licenses/bsd-license.php
     *
     * @param mixed   $in     - valor a ser traduzido
     * @param mixed   $pad_up - se deve existir um comprimento espercifico.
     * @param boolean $to_num - Reverter para numeros.
     *
     * @return string.
     */

    public function indice_textual($in, $to_num=false, $pad_up=false) {
            
        # caracteres que serão usadas no índice textual.
        $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $base  = strlen($index);

        if ($to_num) {

            # tradução de texto para número.
            $in  = strrev($in);
            $out = 0;
            $len = strlen($in) - 1;
            for ($t = 0; $t <= $len; $t++) {
                $bcpow = bcpow($base, $len - $t);
                $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
            }

            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }

        } else {

            # tradução de número para texto.
            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }

            $out = "";

            for ($t = floor(log10($in) / log10($base)); $t >= 0; $t--) {
                $a   = floor($in / bcpow($base, $t));
                $out = $out . substr($index, $a, 1);
                $in  = $in - ($a * bcpow($base, $t));
            }

            $out = strrev($out);

        }

        return $out;
    }


}

?>
