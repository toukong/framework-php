<?php

class database extends config {

    /**
    |
    |   * A conex�o com o banco de dados foi aberta.
    |   * @var boolean
    |
    */

    private $con = false;

    public $result = array();

    /*
    |--------------------------------------------------------------------------
    |   Abre conex�o com o banco de dados.
    |--------------------------------------------------------------------------
    |
    |   * Abre conex�o com o MySQL a partir dos valores referentes ao arquivo de
    |     config.
    |
    |   * @return bolean - A conex�o se confirmar ou n�o.
    |
    */

    public function connect($db=1) {

        # abrindo conex�o.
        $myconn = mysql_connect($this->db[$db]["host"],
                                $this->db[$db]["user"],
                                $this->db[$db]["pass"]) or die(mysql_error());

        # verifica se a conex�o foi aberta.
        if($myconn) {

            # selecionando o banco de dados.
            $sel_db = mysql_select_db($this->db[$db]["data"], $myconn);

            # se o database existir...
            if($sel_db) {

                # confirmar conex�o com a base de dados.
                $this->con = true;

                return true;

            } else {

                # o banco de dados n�o existe.
                return false;

            }

        } else {
            # a conexao n�o funcionou.
            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    |   Fechar conex�o.
    |--------------------------------------------------------------------------
    |
    |   * Fun��o que trata de fechar a conex�o com o banco de dados e o valor
    |     @com.
    |
    |   * @param string $db - conex�o com o database � ser fechada.
    |
    */

    public function close($con=false) {

        if($this->con)
        {
            $this->results = null; // Limpar resultado

            if($con)
            {
                $this->con = false; $this->connect();
            }
        }

    }

    /*
    |--------------------------------------------------------------------------
    |   Fun��o Select.
    |--------------------------------------------------------------------------
    |
    |   * @param string $table - tabela a ser consultada.
    |
    |   * @return array.
    |
    */

    public function select($table, $rows = '*', $where = null, $order = null, $limit = null)  {

        $q = 'SELECT '.$rows.' FROM '.$table;

        if($where != null)
        {
            $q .= ' WHERE '.$where;
        }

        if($order != null)
        {
            $q .= ' ORDER BY '.$order;
        }

        if($limit != null)
        {
            $q .= ' LIMIT '.$limit;
        }

            $query = @mysql_query($q);

            if($query)
            {

                $this->numResults = mysql_num_rows($query);

                for($i = 0; $i < $this->numResults; $i++)
                {
                    $row = mysql_fetch_array($query);

                    $key = array_keys($row);

                    for($x = 0; $x < count($key); $x++)
                    {
                        if(!is_int($key[$x]))
                        {
                            if(mysql_num_rows($query) > 1)
                            {
                                $this->result[$i][$key[$x]] = $row[$key[$x]];
                            }
                            else if(mysql_num_rows($query) < 1)
                            {
                                $this->result = null;
                            }
                            else
                            {
                                $this->result[$key[$x]] = $row[$key[$x]];
                            }
                        }

                    }
                }

                return true;
            }
            else
            {
                return false;
            }

    }

    public function get_result(){
        return $this->result;
    }

}

?>
