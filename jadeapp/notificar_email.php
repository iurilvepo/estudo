<?php
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
include 'connect_app2.php';
    $sql = "SELECT * FROM loginapp ORDER BY `idlogin` DESC";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($result as $row){
 
    // Destinatário
    $mail->addAddress($row['email'], $row['nome']);

    }
*/

include 'connect_app2.php';

// código da notificação SININHO
$sql = "SELECT COUNT(*) AS new_notifications FROM arcondicionadoapp WHERE tipostatus IN ('Pendente', 'Corretiva', 'Preventiva')";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();

$new_notifications = $result['new_notifications'];

//echo $new_notifications;

    // Conteúdo do email
    $mail->isHTML(true);                                  // Define o formato do email como HTML
    $mail->Subject = 'Ar-Condicionado';
    $mail->Body    = '<img src="https://images.vexels.com/content/145463/preview/attention-speech-cartoon-ad200b.png" width="80px">  Existem: <b> ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!</b>';
    $mail->AltBody = 'Existem: ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!';

    // Envia o email
    $mail->send();
    echo 'Mensagem enviada com sucesso';
} catch (Exception $e) {
    echo "A mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
}
?>
