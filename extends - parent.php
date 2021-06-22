<?php

class Retangulo
{
public $largura, $altura;
function __construct($l,$a){

    $this->largura = $l;
    $this->altura = $a;
}
    function calcularArea(){
        return $this->largura * $this->altura;
    }
}
class Quadrado extends Retangulo
{
    function __construct($l){
        $this->largura = $l;
        $this->altura = $l;
    }
} 

$rect = new Retangulo(10,20);
$quad = new Quadrado(10);

echo $rect->calcularArea() . '<br>';
echo $quad->calcularArea() . '<br>';

class Quadrado1 extends Retangulo
{
    function __construct($l){
        parent::__construct($l, $l);
    }
}

$quad1 = new Quadrado1(5);
echo $quad1->calcularArea();


?>
