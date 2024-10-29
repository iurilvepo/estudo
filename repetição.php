<?php

$nomes = ['ana','juca','chicó'];

for($x=0; $x < sizeof($nomes); $x++){

    if($x == 1){
            goto teste; #salta para "teste"
    }

    echo $nomes[$x] . "<br>";

}

echo"<br>";

teste:
echo"TESTE AKI!";



//teste

?>