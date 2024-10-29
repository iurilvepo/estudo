<?php
include('connect_app2.php');

// Função para excluir o registro na tabela 'camaextraapp'
function excluirCama($pdo, $idcama) {
    try {
        // Iniciar transação
        $pdo->beginTransaction();

        // Excluir o registro na tabela 'camaextraapp'
        $stmt = $pdo->prepare("DELETE FROM camaextraapp WHERE idcama = :idcama");
        $stmt->bindParam(':idcama', $idcama, PDO::PARAM_INT);
        $stmt->execute();

        // Commit da transação
        $pdo->commit();

        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Cama Extra Devolvida!";

        echo "<script>
                setTimeout(function() {
                    window.location.href = 'camaextracontroleapp.php';
                }, 2000);
            </script>";
    } catch (PDOException $e) {
        // Rollback da transação em caso de erro
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Erro ao devolver: " . $e->getMessage() . "</div>";
    }
}

// Verificar se a ação de exclusão foi solicitada
if (isset($_GET['excluir_idcama'])) {
    $idcama = intval($_GET['excluir_idcama']);
    excluirCama($pdo, $idcama);
}
?>
