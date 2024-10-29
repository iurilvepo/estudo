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
$pessoa = $_SESSION['nome'];

try {
    // Iniciar transação
    $pdo->beginTransaction();

    // Inserir na tabela camaextraapp
    $sql1 = "INSERT INTO camaextraapp (reserva, qtdcama, qtdberco, checkin, checkout, pessoa) 
             VALUES (:reserva, :qtdcama, :qtdberco, :checkin, :checkout, :pessoa)";
    $stmt1 = $pdo->prepare($sql1);

    $stmt1->bindParam(':reserva', $reserva);
    $stmt1->bindParam(':qtdcama', $qtdcama);
    $stmt1->bindParam(':qtdberco', $qtdberco);
    $stmt1->bindParam(':checkin', $checkin);
    $stmt1->bindParam(':checkout', $checkout);
    $stmt1->bindParam(':pessoa', $pessoa);
    $stmt1->execute();

    // Inserir na tabela relatoriocamaextra
    $sql2 = "INSERT INTO relatoriocamaextra (reserva, qtdcama, qtdberco, checkin, checkout, pessoa) 
             VALUES (:reserva, :qtdcama, :qtdberco, :checkin, :checkout, :pessoa)";
    $stmt2 = $pdo->prepare($sql2);

    $stmt2->bindParam(':reserva', $reserva);
    $stmt2->bindParam(':qtdcama', $qtdcama);
    $stmt2->bindParam(':qtdberco', $qtdberco);
    $stmt2->bindParam(':checkin', $checkin);
    $stmt2->bindParam(':checkout', $checkout);
    $stmt2->bindParam(':pessoa', $pessoa);
    $stmt2->execute();

    // Commit da transação
    $pdo->commit();

    echo "<br><br><br><br><br><br><br><br><br><br><br>
    <center>
    <img src='imagens/sucessoimg1.png' width='120'><br><br><br>Cadastrado com sucesso!";
      
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

/*
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
   // $mail->addAddress('suporte@jadehotel.com.br', 'iuri');

    $sql = "SELECT * FROM loginapp ORDER BY `idlogin` DESC";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($result as $row){
 
    // Destinatário
    $mail->addAddress($row['email'], $row['nome']);

    }


// código da notificação SININHO
$sql = "SELECT tipostatus, COUNT(*) AS count FROM arcondicionadoapp WHERE tipostatus IN ('Preventiva', 'Corretiva', 'Pendente', 'Executado') GROUP BY tipostatus";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$notifications = [
    'Preventiva' => 0,
    'Corretiva' => 0,
    'Pendente' => 0,
    'Executado' => 0
];

foreach ($result as $row) {
    $notifications[$row['tipostatus']] = $row['count'];
}

//echo $new_notifications;

    // Conteúdo do email
    $mail->isHTML(true);                                  // Define o formato do email como HTML
    $mail->Subject = 'Ar-Condicionado';
   // $mail->Body    = '<img src="https://images.vexels.com/content/145463/preview/attention-speech-cartoon-ad200b.png" width="80px">  Existem: <b> ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!</b>';
    
   $mail->Body = '<img src="https://images.vexels.com/content/145463/preview/attention-speech-cartoon-ad200b.png" width="80px"> <br> 
   <h3>Manutenção de Ar-Condicionados:</h3> Precisando de REPARO URGENTE!<br>
   <b> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> ' . $notifications['Corretiva'] . ' Corretiva! <br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> ' . 
   $notifications['Preventiva'] . ' Preventiva! <br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> ' . 
   $notifications['Pendente'] . ' Pendente! <br> <img src="https://cdn-icons-png.flaticon.com/512/10010/10010119.png" width="10px"> ' . 
   $notifications['Executado'] . ' Executado!</b>';
   
   // $mail->AltBody = 'Existem: ' . $new_notifications . ' Pendencia(s) de Ar-Condicionado Precisando de REPARO URGENTE!';

   // Conteúdo alternativo do email em texto simples
    $mail->AltBody = '<h3>Manutenção de Ar-Condicionados:</h3> Precisando de REPARO URGENTE!' . 
    $notifications['Corretiva'] . ' Corretiva! ' . 
    $notifications['Preventiva'] . ' Preventiva! ' . 
    $notifications['Pendente'] . ' Pendente! ' . 
    $notifications['Executado'] . ' Executado!';

    // Envia o email
    $mail->send();
    echo 'Notificação enviada!';
} catch (Exception $e) {
    echo "Notificação não pode ser enviada. Erro: {$mail->ErrorInfo}";
}
    */
?>
