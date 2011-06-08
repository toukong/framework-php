<?php

class benchmark extends config {

    /**
     |--------------------------------------------------------------------------
     |   Benchmark para tempo de carregamento.
     |--------------------------------------------------------------------------
     |
     |   * Verificar o tempo para ser carregado um script. A função deve ser
     |     chamada no inicio e no fim da pagina.
     |
     |   * @param  num  $start - se houver uma chamada anterior da função.
     |
     |   * @return time.
     |
     */

    public function time($start=NULL) {

        # microtime - tempo atual com precisão de microsegundos.
        $now = explode(' ', microtime());
        # quebra as partes e as soma.
        $now = $now[1] + $now[0];

        if ($start == null) {
            # se não houver paramentros retorna o valor atual.
            return $now;
        } else {
            # caso haja um valor inicial retorna o intervalo de tempo.
            return round($now - $start, 4);
        }
    }

}

?>
