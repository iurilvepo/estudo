<?php
session_start();

if (!isset($_SESSION['idlogin'])) {
    header("location: index.php");
    exit;
}

include_once("connect_app2.php");

$idarc = filter_input(INPUT_POST, 'idarc', FILTER_SANITIZE_NUMBER_INT);
$tipostatus = filter_input(INPUT_POST, 'tipostatus', FILTER_SANITIZE_STRING);
$observacao = filter_input(INPUT_POST, 'observacao', FILTER_SANITIZE_STRING);
$observacaotec = filter_input(INPUT_POST, 'observacaotec', FILTER_SANITIZE_STRING);
$servico = filter_input(INPUT_POST, 'servico', FILTER_SANITIZE_STRING);
$pessoa = $_SESSION['nome'];
$nivel = $_SESSION['nivel'];
$novoNome = null;

try {
    // Verificar se um arquivo foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $extensao = strtolower(substr($_FILES['imagem']['name'], -4)); // Pega a extensão do arquivo
        $novoNome = md5(time()) . $extensao; // Define o nome do arquivo
        $diretorio = "uploads/"; // Define o diretório para onde enviaremos o arquivo

        // Verifica se o diretório existe, se não, cria
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio . $novoNome);
    }

    if ($nivel == "Gerencia" || $nivel == "Manutencao" || $nivel == "Admin") {
        $sql = "UPDATE arcondicionadoapp SET tipostatus = :tipostatus, observacao = :observacao, servico = :servico, pessoa = :pessoa, imagem = :imagem WHERE idarc = :idarc";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':observacao', $observacao, PDO::PARAM_STR);
        $stmt->bindParam(':pessoa', $pessoa, PDO::PARAM_STR);
    } elseif ($nivel == "Prestador") {
        $sql = "UPDATE arcondicionadoapp SET tipostatus = :tipostatus, observacaotec = :observacaotec, servico = :servico, pessoatec = :pessoatec, datatec = :datatec, imagem = :imagem WHERE idarc = :idarc";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':observacaotec', $observacaotec, PDO::PARAM_STR);
        $stmt->bindParam(':pessoatec', $pessoa, PDO::PARAM_STR);
        $stmt->bindParam(':datatec', date("Y-m-d H:i:s"), PDO::PARAM_STR);
    } else {
        throw new Exception("Nível de acesso inválido.");
    }

    // Vinculando os parâmetros comuns
    $stmt->bindParam(':imagem', $novoNome, PDO::PARAM_STR);
    $stmt->bindParam(':tipostatus', $tipostatus, PDO::PARAM_STR);
    $stmt->bindParam(':servico', $servico, PDO::PARAM_STR);
    $stmt->bindParam(':idarc', $idarc, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Atualizado com sucesso!";
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'arcondicionadoapp.php';
                }, 2000);
            </script>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao atualizar o status!</div>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
