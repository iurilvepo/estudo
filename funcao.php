<?php

echo "Inicio da nossa aplicação!!! <br>";

$nomes = ['ana','lucas','bobe'];

#repetidor //foreach é usado para arrays!!!
#POR CADA - REPETIÇÃO // $NOMES passará o valor do array para $NOME
foreach($nomes as $nome){
    funcao($nome);
}


function funcao($valor){

echo "Valor - ". $valor . '<br>';

}




?>