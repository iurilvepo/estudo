<?php

$falar = function($mensagem){
    echo 'A minha mensagem é: ' . $mensagem;

};

    function minha_funcao(callable $funcao, $dados){
        $funcao($dados);
    }

minha_funcao($falar, 'Esta é a minha mensagem.');
?>