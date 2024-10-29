<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

include_once("connect_app2.php");

//pega o id que vem pelo GET, da pagina do botão excluir!!!
if(isset($_GET['idarc'])){
    $idarc = $_GET['idarc'];


        try{
//executa a exclusão!!!
        $sql = "DELETE FROM arcondicionadoapp WHERE `idarc` = :idarc";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':idarc', $idarc, PDO::PARAM_INT);

            if($stmt -> execute()){
                echo"<br><br><br><br><br><br><br><br><br>";
                echo "<center>
                        <img src='imagens/sucessoimg1.png' width='120'><br><br><br>Registro Excluido!
                      </center>";

                echo "<script>
                        setTimeout(function() {
                            window.location.href = 'arcondicionadoapp.php';
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