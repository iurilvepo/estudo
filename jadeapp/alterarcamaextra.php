<?php

session_start();

if(!isset($_SESSION['idlogin'])){
    header("location: index.php");
    exit();
}

include_once("connect_app2.php");

$reserva = $_POST['reserva'];
$qtdcama = $_POST['qtdcama'];
$qtdberco = $_POST['qtdberco'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$idcama = $_POST['idcama'];

try {
    // Iniciar transação
    $pdo->beginTransaction();

    // Atualizar a tabela camaextraapp
    $sql1 = "UPDATE camaextraapp SET reserva = :reserva, qtdcama = :qtdcama, qtdberco = :qtdberco, checkin = :checkin, checkout = :checkout 
             WHERE idcama = :idcama";
    $stmt1 = $pdo->prepare($sql1);

    $stmt1->bindParam(':reserva', $reserva);
    $stmt1->bindParam(':qtdcama', $qtdcama);
    $stmt1->bindParam(':qtdberco', $qtdberco);
    $stmt1->bindParam(':checkin', $checkin);
    $stmt1->bindParam(':checkout', $checkout);
    $stmt1->bindParam(':idcama', $idcama);
    $stmt1->execute();

    // Atualizar a tabela relatoriocamaextra
    $sql2 = "UPDATE relatoriocamaextra SET reserva = :reserva, qtdcama = :qtdcama, qtdberco = :qtdberco, checkin = :checkin, checkout = :checkout 
             WHERE idcama = :idcama";
    $stmt2 = $pdo->prepare($sql2);

    $stmt2->bindParam(':reserva', $reserva);
    $stmt2->bindParam(':qtdcama', $qtdcama);
    $stmt2->bindParam(':qtdberco', $qtdberco);
    $stmt2->bindParam(':checkin', $checkin);
    $stmt2->bindParam(':checkout', $checkout);
    $stmt2->bindParam(':idcama', $idcama);  // Adicionando o idcama corretamente
    $stmt2->execute();

    // Commit da transação
    $pdo->commit();

    echo "<br><br><br><br><br><br><br><br><br><br><br>
    <center>
    <img src='imagens/verificad12.gif' width='120'><br><br><br>Alterado com sucesso!";

    echo "<script>
            setTimeout(function() {
                window.location.href = 'camasapp.php';
            }, 2000);
         </script>";
} catch (Exception $e) {
    // Rollback da transação em caso de erro
    $pdo->rollBack();
    echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
}

echo "<br>";     

?>
