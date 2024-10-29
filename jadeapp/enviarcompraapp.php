<?php
session_start();

if(!isset($_SESSION['idlogin'])){
    header("location: index.php");
}else{}

include_once("connect_app2.php");

$material = $_POST['material'];
$qtd = $_POST['qtd'];
$empresa = $_POST['empresa'];
$setor_destino = $_POST['setor_destino'];
$link = $_POST['link'];
$observacao = $_POST['observacao'];
$pessoa = $_SESSION['nome'];


$sql = "INSERT INTO `comprasapp` (`material`, `quantidade`, `empresa`, `link`, `observacao`, `solicitante`, `setor_destino`, `datapedido`) VALUES (:material, :quantidade, :empresa, :link, :observacao, :solicitante, :setor_destino, NOW())";
$stmt = $pdo -> prepare($sql);

$stmt->bindParam(':material', $material);
$stmt->bindParam(':quantidade', $qtd);
$stmt->bindParam(':empresa', $empresa);
$stmt->bindParam(':link', $link);
$stmt->bindParam(':observacao', $observacao);
$stmt->bindParam(':solicitante', $pessoa);
$stmt->bindParam(':setor_destino', $setor_destino);

    if($stmt -> execute()){
        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Solicitado com sucesso!";
      
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'comprasapp.php';
                }, 2000);
             </script>";
    } else{
        exit($stmt -> errorInfo()[2]);
    }




    echo "<br>";    
    // Importa as classes necessárias do PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    // Inclui o autoloader do Composer
    require 'vendor/autoload.php';
    
    // Cria uma nova instância do PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // Configurações do servidor
        $mail->SMTPDebug = 0;                                 // 0 para desabilitar debug, 2 para debug detalhado
        $mail->isSMTP();                                      // Usa SMTP
        $mail->Host       = 'smtp.gmail.com';                 // Servidor SMTP
        $mail->SMTPAuth   = true;                             // Habilita autenticação SMTP
        $mail->Username   = 'suporte@jadehotel.com.br';       // Usuário SMTP
        $mail->Password   = 'rzjd oody othj siss';            // Senha SMTP
        $mail->SMTPSecure = 'tls';                            // Habilita criptografia TLS
        $mail->Port       = 587;                              // Porta TCP para TLS
    
        // Remetente
        $mail->setFrom('suporte@jadehotel.com.br', 'APP JADE');
        $mail->addAddress('compras@jadehotel.com.br', 'Compras');  //Setor de Compras
    
        $sql = "SELECT * FROM loginapp ORDER BY `idlogin` DESC";
    
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($result as $row){
     
                if($row['flagcomprasapp'] == 1 && $pessoa == $row['nome']){

                    // Destinatário
                    $mail->addAddress($row['email'], $row['nome']);
                }
              
        }
    
    
        // Conteúdo do email
        $mail->isHTML(true);                                  // Define o formato do email como HTML
        $mail->Subject = 'SOLICITACAO DE COMPRA!  ' .$setor_destino;
       // $mail->Body    = '<img src="https://images.vexels.com/content/145463/preview/attention-speech-cartoon-ad200b.png" width="80px">  Existem: <b> ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!</b>';
        
       $mail->Body = '<img src="https://cdn-icons-png.flaticon.com/512/5253/5253581.png" width="80px">
       <h3>SOLICITACAO DE COMPRA </h3> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Material:</strong> '. $material .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Empresa:</strong> ' . $empresa . '<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Setor:</strong> ' . $setor_destino 
       .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Solicitante:</strong> ' . $pessoa .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Quantidade:</strong> ' . $qtd .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Link:</strong> ' . $link 
       .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Observacao:</strong> ' . $observacao;
       
       // $mail->AltBody = 'Existem: ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!';
    
       // Conteúdo alternativo do email em texto simples
        $mail->AltBody = '<img src="https://cdn-icons-png.flaticon.com/512/5253/5253581.png" width="80px">
       <h3>SOLICITACAO DE COMPRA </h3> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Material:</strong> '. $material .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Empresa:</strong> ' . $empresa . '<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Setor:</strong> ' . $setor_destino 
       .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Solicitante:</strong> ' . $pessoa .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Quantidade:</strong> ' . $qtd .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Link:</strong> ' . $link 
       .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"><strong> Observacao:</strong> ' . $observacao;

        // Envia o email
        $mail->send();
        echo '<strong>Compra enviada!</strong>';
    } catch (Exception $e) {
        echo "Compra não pode ser enviada. Erro: {$mail->ErrorInfo}";
    }

?>
