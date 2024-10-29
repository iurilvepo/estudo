<?php
include('connect_app2.php');
$quarto = $_POST['quarto'];
// Função para vincular o camamontada nas tabelas 'camaextraapp' e 'relatoriocamaextra'
function vincularCamamontada($pdo, $idcama, $camamontada) {
    try {
        // Iniciar transação
        $pdo->beginTransaction();

        // Atualizar o campo 'camamontada' na tabela 'camaextraapp'
        $stmt1 = $pdo->prepare("UPDATE camaextraapp SET camamontada = :camamontada WHERE idcama = :idcama");
        $stmt1->bindParam(':camamontada', $camamontada, PDO::PARAM_STR);
        $stmt1->bindParam(':idcama', $idcama, PDO::PARAM_INT);
        $stmt1->execute();

        // Atualizar o campo 'camamontada' na tabela 'relatoriocamaextra'
        $stmt2 = $pdo->prepare("UPDATE relatoriocamaextra SET camamontada = :camamontada WHERE idcama = :idcama");
        $stmt2->bindParam(':camamontada', $camamontada, PDO::PARAM_STR);
        $stmt2->bindParam(':idcama', $idcama, PDO::PARAM_INT);
        $stmt2->execute();

        // Commit da transação
        $pdo->commit();

        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/verificad12.gif' width='120'><br><br><br>Cama alterada com sucesso!";
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'camasapp.php';
                }, 2000);
            </script>";
    } catch (PDOException $e) {
        // Rollback da transação em caso de erro
        $pdo->rollBack();
        echo "<div class='alert alert-danger'>Erro ao vincular a cama: " . $e->getMessage() . "</div>";
    }
}

// Verificar se a ação de vinculação foi solicitada
if (isset($_POST['idcama']) && isset($_POST['camamontada'])) {
    $idcama = intval($_POST['idcama']);
    $camamontada = $_POST['camamontada'];
    vincularCamamontada($pdo, $idcama, $camamontada);
}



if($camamontada == '1'){
    $montada = "<b>SIM, foi montada!</b>";
}else {
    $montada = "<b>NÃO foi montada!</b>";
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
    $mail->Subject = 'CAMA EXTRA MONTADA!  ' .$quarto;
   // $mail->Body    = '<img src="https://images.vexels.com/content/145463/preview/attention-speech-cartoon-ad200b.png" width="80px">  Existem: <b> ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!</b>';
    
   $mail->Body = '<img src="https://cdn-icons-png.flaticon.com/512/10088/10088998.png" width="80px">
   <h3>CAMA EXTRA </h3> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> UH: '. $quarto .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> ' . $montada;
   
   // $mail->AltBody = 'Existem: ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!';

   // Conteúdo alternativo do email em texto simples
    $mail->AltBody = '<img src="https://png.pngtree.com/png-vector/20191003/ourmid/pngtree-bed-icon-isolated-on-abstract-background-png-image_1779537.jpg" width="80px"> 
   <h3>CAMA EXTRA </h3> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> UH: '. $quarto .'<br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> ' . $montada;
    // Envia o email
    $mail->send();
    echo 'Notificação enviada!';
} catch (Exception $e) {
    echo "Notificação não pode ser enviada. Erro: {$mail->ErrorInfo}";
}


?>
