<?php

class Humano
{
    private $nome = 'x';

    function setPrivate($objeto, $valor){
        $objeto->nome = $valor;
    }

    function apresentar(){
        echo $this->nome;
    }
}

$a = new Humano();
$b = new Humano();
$a->setPrivate($b,'joao');

$a->apresentar();
echo '<br>';
$b->apresentar();
?>
