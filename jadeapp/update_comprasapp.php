<?php
// Inclui a conexão ao banco de dados
include 'connect_app2.php'; // Certifique-se de que esse arquivo contém a conexão PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os valores dos checkboxes, definindo "0" se não estiver marcado
    $nf = isset($_POST['nf']) ? 1 : 0;
    $boleto = isset($_POST['boleto']) ? 1 : 0;
    $em_pagamento = isset($_POST['em_pagamento']) ? 1 : 0;
    $status = $_POST['status'];
    $idcompras = $_POST['idcompras']; // O ID do registro que será atualizado

    try {
        // Constrói a query de atualização
        $sql = "UPDATE comprasapp SET 
                    nf = :nf, 
                    boleto = :boleto, 
                    em_pagamento = :em_pagamento, 
                    status = :status
                WHERE idcompras = :idcompras";

        // Prepara e executa a consulta usando PDO
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nf', $nf, PDO::PARAM_INT);
        $stmt->bindParam(':boleto', $boleto, PDO::PARAM_INT);
        $stmt->bindParam(':em_pagamento', $em_pagamento, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':idcompras', $idcompras, PDO::PARAM_INT);

        // Executa a query
        $stmt->execute();

        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Atualizado com sucesso!";
      
        
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
