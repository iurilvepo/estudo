<?php
// Inclui a conexão ao banco de dados
include 'connect_app2.php'; // Certifique-se de que esse arquivo contém a conexão PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_recebimento = !empty($_POST['data_recebimento']) ? $_POST['data_recebimento'] : NULL;
    $idcompras = $_POST['idcompras']; // O ID do registro que será atualizado

    try {
        // Constrói a query de atualização
        $sql = "UPDATE comprasapp SET 
                    data_recebimento = :data_recebimento 
                WHERE idcompras = :idcompras";

        // Prepara e executa a consulta usando PDO
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':data_recebimento', $data_recebimento);
        $stmt->bindParam(':idcompras', $idcompras, PDO::PARAM_INT);

        // Executa a query
        $stmt->execute();

        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Material Recebido!";
      
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'comprasapp.php';
                }, 2000);
             </script>";

    } catch (PDOException $e) {
        echo "Erro ao atualizar o registro: " . $e->getMessage();
    }
}
?>
