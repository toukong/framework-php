<?php

class database extends config {

    /**
    |
    |   * A conexão com o banco de dados foi aberta.
    |   * @var boolean
    |
    */

    private $con = false;

    public $result = array();

    /*
    |--------------------------------------------------------------------------
    |   Abre conexão com o banco de dados.
    |--------------------------------------------------------------------------
    |
    |   * Abre conexão com o MySQL a partir dos valores referentes ao arquivo de
    |     config.
    |
    |   * @return bolean - A conexão se confirmar ou não.
    |
    */

    public function connect($db=1) {

        # abrindo conexão.
        $myconn = mysql_connect($this->db[$db]["host"],
                                $this->db[$db]["user"],
                                $this->db[$db]["pass"]) or die(mysql_error());

        # verifica se a conexão foi aberta.
        if($myconn) {

            # selecionando o banco de dados.
            $sel_db = mysql_select_db($this->db[$db]["data"], $myconn);

            # se o database existir...
            if($sel_db) {

                # confirmar conexão com a base de dados.
                $this->con = true;

                return true;

            } else {

                # o banco de dados não existe.
                return false;

            }

        } else {
            # a conexao não funcionou.
            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    |   Fechar conexão.
    |--------------------------------------------------------------------------
    |
    |   * Função que trata de fechar a conexão com o banco de dados e o valor
    |     @com.
    |
    |   * @param string $db - conexão com o database à ser fechada.
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
    |   Função Select.
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
