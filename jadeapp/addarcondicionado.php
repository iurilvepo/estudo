<?php
session_start();

if(!isset($_SESSION['idlogin'])){
    header("location: index.php");
}else{}

include_once("connect_app2.php");

$apartamento = $_POST['apartamento'];
$bloco = $_POST['bloco'];
$tipostatus = $_POST['tipostatus'];
$observacao = $_POST['observacao'];
$pessoa = $_SESSION['nome'];

$sql = "INSERT INTO `arcondicionadoapp` (`apartamento`, `bloco`, `tipostatus`, `observacao`, `pessoa`, `data`) VALUES (:apartamento, :bloco, :tipostatus, :observacao, :pessoa, NOW())";
$stmt = $pdo -> prepare($sql);

$stmt->bindParam(':apartamento', $apartamento);
$stmt->bindParam(':bloco', $bloco);
$stmt->bindParam(':tipostatus', $tipostatus);
$stmt->bindParam(':observacao', $observacao);
$stmt->bindParam(':pessoa', $pessoa);

    if($stmt -> execute()){
        echo "<br><br><br><br><br><br><br><br><br><br><br>
        <center>
        <img src='imagens/sucessoimg1.png' width='120'><br><br><br>Cadastrado com sucesso!";
      
        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'manutencaoapp.php';
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
    //$mail->addAddress('danielaraujosousa17@gmail.com', 'Sempre Gelar'); //empresa contratada!!!

    $sql = "SELECT * FROM loginapp ORDER BY `idlogin` DESC";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($result as $row){
 
        if($row['flagarapp'] == 1){
        // Destinatário
        $mail->addAddress($row['email'], $row['nome']);
        }
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
    echo '<strong>Notificação enviada!</strong>';
} catch (Exception $e) {
    echo "Notificação não pode ser enviada. Erro: {$mail->ErrorInfo}";
}
?>
