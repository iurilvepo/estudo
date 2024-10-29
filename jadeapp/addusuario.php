<?php
session_start();

if(!isset($_SESSION['idlogin'])){
    header("location: index.php");
}else{ }

include_once("connect_app2.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$nivel = $_POST['nivel'];
$senha = $_POST['senha'];

$sql = "INSERT INTO `loginapp` (`nome`, `email`, `nivel`, `senha`) VALUES (:nome, :email, :nivel, :senha)";
$stmt = $pdo -> prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':nivel', $nivel);
$stmt->bindParam(':senha', md5($senha));

    if($stmt -> execute()){
        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/sucessoimg1.png' width='120'><br><br><br>Cadastrado com sucesso!";
      
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'usuarioapp.php';
                }, 2000);
             </script>";

    } else{

        exit($stmt -> errorInfo()[2]);
        
    }

?>