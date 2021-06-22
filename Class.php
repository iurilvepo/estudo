<?php

class Humano
{

    private $nome;
    private $apelido;


        function __construct($n, $a){
            $this->nome = $n;
            $this->apelido = $a;
        }
        public function nomeCompleto(){
            return $this->nome . ' ' . $this->apelido;
        }

}

$homem = new Humano('Joao','Ribeiro');
$mulher = new Humano('ana','Martins');

echo $homem->nomeCompleto();
echo '<br>';
echo $mulher->nomeCompleto();



?>