<?php
// Parâmetros de conexão com o banco de dados Oracle
$host = "10.61.6.100"; // Endereço IP do servidor Oracle
$sid = "xe";      // Substitua pelo SID do banco de dados
$user = "cm";          // Nome de usuário do banco de dados
$password = "oracle11g"; // Senha do banco de dados

// String de conexão
$connection = oci_connect($user, $password, "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=1521)))(CONNECT_DATA=(SID=$sid)))");

// Verifica se a conexão foi bem-sucedida
if (!$connection) {
    $error = oci_error();
    die("Erro de conexão: " . $error['message']);
} else {
    echo "Conexão bem-sucedida!";
}

?>