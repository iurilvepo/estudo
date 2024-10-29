<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

include('connect_app2.php');


// Função para verificar o nível de acesso
function verificarPermissao($pdo, $nomeUsuario) {
  $sql = "SELECT nivel FROM loginapp WHERE nome = :nome";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(['nome' => $nomeUsuario]);
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($usuario) {
      return $usuario['nivel'];
  } else {
      return null;
  }
}


// Exemplo de uso da função
$nomeUsuario = $_SESSION['nome'];; // Substitua pelo nome do usuário atual
$nivel = verificarPermissao($pdo, $nomeUsuario);

?>

<!DOCTYPE html">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" media="all" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<title>Jade</title>
</head>

<body>
</br>
</br>
</br>
</p>

<center>
<h4>
<!-- Inicio do código Saudação e data em JS-->
<script language="JavaScript" type="text/JavaScript">
 
var dataHora, xHora, xDia, dia, mes, ano, saudacao;
dataHora = new Date();
xHora = dataHora.getHours();

if (xHora >= 0 && xHora <12) {saudacao = "Bom Dia -"}
if (xHora >= 12 && xHora < 18) {saudacao = "Boa Tarde -"}
if (xHora >= 18 && xHora <= 23) {saudacao = "Boa Noite -"}

xDia = dataHora.getDay();

diaSem = new Array(7);

diaSem[0] = "Domingo";
diaSem[1] = "Segunda-feira";
diaSem[2] = "Terça-feira";
diaSem[3] = "Quarta-feira";
diaSem[4] = "Quinta-feira";
diaSem[5] = "Sexta-feira";
diaSem[6] = "Sábado";

dia = dataHora.getDate();
mes = dataHora.getMonth();

mesAno = new Array(12);

mesAno[0] = "Janeiro";
mesAno[1] = "Fevereiro";
mesAno[2] = "Março";
mesAno[3] = "Abril";
mesAno[4] = "Maio";
mesAno[5] = "Junho";
mesAno[6] = "Julho";
mesAno[7] = "Agosto";
mesAno[8] = "Setembro";
mesAno[9] = "Outubro";
mesAno[10] = "Novembro";
mesAno[11] = "Dezembro";

ano = dataHora.getFullYear();

document.write("<font face='verdana', arial' size=1.5 color='828282'>" + "Olá <b><?php echo $_SESSION['nome'];?></b> " + saudacao + " " + diaSem[xDia] + ", " + dia + " de " + mesAno[mes] + " de " + ano + "</font>");

</script>
</h4></p></center>
<!-- Fim do código Saudação e data em JS-->

<center>
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-0">
  <?php if ($nivel) { 
    
    switch ($nivel) {
      case 'Admin':
      ?>
      <div class="col">  
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
          <center>
            <a href="usuarioapp.php" class="link-underline-light">
              <img src="imagens/addpessoas.png" width="80">
              <h6 class="card-title">USUÁRIOS</h6>
            </a>
          </center>
        </div>
      </div>
      <?php
          
      case 'Gerencia':
      case 'Manutencao':
      case 'Compras':
      ?>
      <div class="col">
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
          <center>
            <a href="manutencaoapp.php" class="link-underline-light">
              <img src="imagens/iconmanutencao.png" width="80">
              <h6 class="card-title">GERAR O.S.</h6>
            </a>
          </center>
        </div>
      </div>

      <div class="col">
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
          <center>
            <a href="relatoriosapp.php" class="link-underline-light">
              <img src="imagens/relatorioapp.png" width="80">
              <h6 class="card-title">RELATÓRIOS</h6>
            </a>
          </center>
        </div>
      </div>

      <div class="col">
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
          <center>
            <a href="camasapp.php" class="link-underline-light">
              <img src="imagens/camagov01.png" width="80">
              <h6 class="card-title">CAMA EXTRA</h6>
            </a>
          </center>
        </div>
      </div>

      <div class="col">
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
          <center>
            <a href="comprasapp.php" class="link-underline-light">
              <img src="imagens/compras369.png" width="80">
              <h6 class="card-title">COMPRAS</h6>
            </a>
          </center>
        </div>
      </div>
      
      <?php
          
      case 'Prestador':
      ?>
      <div class="col">
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
          <center>
            <a href="arcondicionadoapp.php" class="link-underline-light">
              <img src="imagens/arcondicionado.png" width="80">
              <h6 class="card-title">AR-CONDICIONADO</h6>
            </a>
          </center>
        </div>
      </div>
  
  <!--
  <div class="col">
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow">
    <center>
    <a href="sair.php" class="link-underline-light">
      <img src="imagens/sairapp.png" width="80"><h6 class="card-title">SAIR!</h6>
    </a>
    </center>
    </div>
  </div>
        -->
  <?php 
    break;
  default:

            echo "&nbsp; &nbsp; <center><img src='imagens/permissao321.png' width='120px'><br>Usuário sem Permissão!</center>";
            break;
    }

} else {
  echo "&nbsp; &nbsp; Usuário não encontrado!";
}
  ?>
</div>
</center>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>