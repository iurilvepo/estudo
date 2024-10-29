<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

include_once("connect_app2.php");

//pega o id que vem pelo GET, da pagina do botão excluir!!!
if(isset($_GET['idlogin'])){
    $idlogin = $_GET['idlogin'];


        try{
//executa a exclusão!!!
        $sql = "DELETE FROM loginapp WHERE `idlogin` = :idlogin";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':idlogin', $idlogin, PDO::PARAM_INT);

            if($stmt -> execute()){
                echo"<br><br><br><br><br><br><br><br><br>";
                echo "<center>
                        <img src='imagens/sucessoimg1.png' width='120'><br><br><br>Usuário Excluido!
                      </center>";

                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'listausuariosapp.php';
                        }, 2000);
                    </script>";

            }else{
                exit($stmt->errorInfo()[2]);
            }
        } catch(PDOException $e){
            echo"Erro ao Excluir: " . $e->getMessage();
        }

}else{
    echo"Registro não encontrado!";
}

?>