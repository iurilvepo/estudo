<?php

$a = function(){
    echo 'Olá <br>';
};

$a();


$andar = function($metros){

    return "Andei $metros metros!!!";

};

echo $andar(100);


$x = 20;
$y = 30;

$minhaClosure = function($z) use($x, $y){
echo "$z - $x - $y";
};

$minhaClosure(10);

echo "<p>$y</p>";




function gerador_numero(){
    for($i = 0; $i < 10; $i++){
        yield $i;
    }
}
foreach(gerador_numero() as $numero){
echo "numero";

}


?>