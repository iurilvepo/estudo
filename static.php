<?php

class Operacoes
{
    static function numeroAleatorio($min, $max){
        return rand($min, $max);
    }

    static function calcularFormula($a ,$b){
        return ($a*2)+($b+$a);
    }

    static function criaUmNome(){
        $nomes = ['joao', 'ana', 'Zezinho'];
        $apelidos = ['silva', 'oliveira','juca'];
        return $nomes[rand(0,count($nomes)-1)] . ' ' . $apelidos[rand(0,count($apelidos)-1)];
    }

}

echo Operacoes::numeroAleatorio(0,1000);
echo '<br>';
echo Operacoes::calcularFormula(10,20);
echo '<br>';
echo Operacoes::criaUmNome();

?>