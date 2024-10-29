<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

include_once("connect_app2.php");

//pega o id que vem pelo GET, da pagina do botão excluir!!!
if(isset($_GET['idcompras'])){
    $idcompras = $_GET['idcompras'];


        try{
//executa a exclusão!!!
        $sql = "DELETE FROM comprasapp WHERE `idcompras` = :idcompras";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':idcompras', $idcompras, PDO::PARAM_INT);

            if($stmt -> execute()){
                echo"<br><br><br><br><br><br><br><br><br>";
                echo "<center>
                        <img src='imagens/verificad12.gif' width='120'><br><br><br>Excluido com Sucesso!
                      </center>";

                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'comprasapp.php';
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