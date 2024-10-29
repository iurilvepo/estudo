<?php
/*
$host = '186.202.152.67';
$db = 'jadehotel';
$user = 'jadehotel';
$password = 'Vitlnx!@#2009';
*/

$host = 'localhost';
$db = 'jadehotel';
$user = 'preco';
$password = 'vitlnx2009';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}


?>