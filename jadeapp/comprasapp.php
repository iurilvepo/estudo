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
</br>
<center>
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-0">
<?php if ($nivel) { 
  
  switch ($nivel) {
    case 'Admin':
    case 'Gerencia':
    case 'Manutencao':
    case 'Compras':
    ?>
  <div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
    <center>
    <a href="solicitarcomprasapp.php" class="link-underline-light">
      <img src="imagens/solicitarcomp231.png" width="80"><h6 class="card-title">SOLICITAR</h6>
    </a>
    </center>
    </div>
  </div>
  
  <div class="col">
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
    <center>
    <a href="vercomprasapp.php" class="link-underline-light">
      <img src="imagens/compras369.png" width="80"><h6 class="card-title">COMPRAS</h6>
    </a>
    </center>
    </div>
  </div>

  <div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
    <center>
    <a href="relatoriocomprasapp.php" class="link-underline-light">
      <img src="imagens/relatorioapp3.png" width="60"><h6 class="card-title">RELATÓRIO DE COMPRA</h6>
    </a>
    </center>
    </div>
  </div>
  <center>
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
</center>
</div>
<br>
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-0">
            <div class="col">
                <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
                    <a href="inicial.php" class="link-underline-light">
                        <center>
                            <img src="imagens/voltaricon.png" width="50">
                            <br>
                            <h7 class="card-title"> Voltar </h7>
                        </center>
                    </a>
                </div>
            </div>

            <div class="col">
                <!-- Additional content can go here -->
            </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>