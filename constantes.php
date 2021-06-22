<?php

class Circulo
{
    const PI = 3.14;
}

echo Circulo::PI;

echo '<br>';

$c = new Circulo();
echo $c::PI;
echo '<br>';
#-------------------------

define('APP_NAME', 'Minha Aplicação');
define('VERSAO', '1.0.0');
define('MOSTRAR_ERROS', true);
define('PI', 3.14);

echo APP_NAME;
echo '<br>';
echo VERSAO;
echo '<br>';

#-------------------------

#verifica se uma constante já existe
if(!defined('APP_NAME')){
    define('APP_NAME', 'Minha App');
}
echo APP_NAME;
echo '<br>';

#mais comum 
defined('CONSTANTE') or define('CONSTANTE', 'valor');

#--------------------------

echo '<br>';
#constante com um array
const NOMES = ['joao','paulo','matias'];
echo NOMES[1];
echo '<br>';

#array no define
define('NAMES', ['joao','juca','zezinho']);
echo NAMES[2];


echo '<br>';
?>


<?php

echo __LINE__ . '<br>'; # indica o numero da linha 
echo __FILE__ . '<br>'; # indica o caminho do arquivo até ele
echo __DIR__ . '<br>'; # indica o caminho até a pasta


teste();

function teste(){
    $a = true;
    echo __FUNCTION__ . '<br>'; # indica o nome da Função
}

class MinhaClasse
{
    function identificar(){
        echo __CLASS__ . '<br>'; # indica o nome da Class
        echo __METHOD__ . '<br>'; # indica o nome do Método
    }
}

$c = new MinhaClasse();
$c->identificar();


echo __NAMESPACE__; # indica o nome do namespace atual
?>