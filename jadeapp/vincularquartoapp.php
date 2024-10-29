<?php
include('connect_app2.php');

// Função para vincular o quarto nas tabelas 'camaextraapp' e 'relatoriocamaextra'
function vincularQuarto($pdo, $idcama, $quarto) {
    try {
        // Iniciar transação
        $pdo->beginTransaction();

        // Atualizar o campo 'quarto' na tabela 'camaextraapp'
        $stmt1 = $pdo->prepare("UPDATE camaextraapp SET quarto = :quarto WHERE idcama = :idcama");
        $stmt1->bindParam(':quarto', $quarto, PDO::PARAM_STR);
        $stmt1->bindParam(':idcama', $idcama, PDO::PARAM_INT);
        $stmt1->execute();

        // Atualizar o campo 'quarto' na tabela 'relatoriocamaextra'
        $stmt2 = $pdo->prepare("UPDATE relatoriocamaextra SET quarto = :quarto WHERE idcama = :idcama");
        $stmt2->bindParam(':quarto', $quarto, PDO::PARAM_STR);
        $stmt2->bindParam(':idcama', $idcama, PDO::PARAM_INT);
        $stmt2->execute();

        // Commit da transação
        $pdo->commit();

        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Quarto vinculado com sucesso!";
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'camasapp.php';
                }, 2000);
            </script>";
    } catch (PDOException $e) {
        // Rollback da transação em caso de erro
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Erro ao vincular o quarto: " . $e->getMessage() . "</div>";
    }
}

// Verificar se a ação de vinculação foi solicitada
if (isset($_POST['idcama']) && isset($_POST['quarto'])) {
    $idcama = intval($_POST['idcama']);
    $quarto = $_POST['quarto'];
    vincularQuarto($pdo, $idcama, $quarto);
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
    $mail->addAddress('suporte@jadehotel.com.br', 'iuri');

   /*
    $sql = "SELECT * FROM loginapp ORDER BY `idlogin` DESC";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($result as $row){
 
    // Destinatário
    $mail->addAddress($row['email'], $row['nome']);

    }
*/


    // Conteúdo do email
    $mail->isHTML(true);                                  // Define o formato do email como HTML
    $mail->Subject = 'MONTAR CAMA EXTRA!  '. $quarto;
   // $mail->Body    = '<img src="https://images.vexels.com/content/145463/preview/attention-speech-cartoon-ad200b.png" width="80px">  Existem: <b> ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!</b>';
    
   $mail->Body = '<img src="https://cdn-icons-png.flaticon.com/512/9821/9821139.png" width="80px"> <br> 
   <h3><img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> Realizar a montagem de CAMA EXTRA! </h3> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> UH: ' . $quarto;
   
   // $mail->AltBody = 'Existem: ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!';

   // Conteúdo alternativo do email em texto simples
    $mail->AltBody = '<img src="https://cdn-icons-png.flaticon.com/512/9821/9821139.png" width="80px"> <br> 
   <h3><img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> Realizar a montagem de CAMA EXTRA! </h3> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> UH: ' . $quarto;
    // Envia o email
    $mail->send();
    echo 'Notificação enviada!';
} catch (Exception $e) {
    echo "Notificação não pode ser enviada. Erro: {$mail->ErrorInfo}";
}


?>
