<?php

$a = 1;

#ISSET verifica se a variavel está definida!
if (isset($a)){
    echo 'existe <br>';
} else {
    echo 'Não existe!';
}

#------------------------
#EMPTY verifica se a variavel tem valor vazio, e retorna verdadeiro ou falso.

$b = 'joao';
empty($b); //false

$c = false;
empty($c); //true

$nomes = [];
empty($nomes); //true

$outro = null;
empty($outro); //true


#-------------------
#IS_NULL verifica se uma variável tem valor null ou não

$d = 'joao';
is_null($d); //false

$e = null;
is_null($e); //true

#------------------------

#UNSET permite Destruir uma variavel, e removida da memória

$a = 'joao';
unset($a);

?>