<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

$pessoa = $_SESSION['nome'];

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

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<!--Custom styles-->
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<!--Fim styles-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<title>Jade</title>
</head>

<body>
</br>
</br>
</br>
</br>
<label style="font-family: poppins";><p><b><img src="imagens/camagov01.png" width="50"> &nbsp;&nbsp; Cama Extra</b></p></label>
 
<?php if ($nivel) { 
  
  switch ($nivel) {
    case 'Admin':
    case 'Gerencia':
   
    ?>
          <form class="row g-0 gy-2 align-items-center" action="addcamaextra.php" method="post">

            <div class="col-sm-3">
              <label for="reserva" style='font-size: 11px;'> <strong>Nº da Reserva</strong></label>
              <input type="text" class="form-control" name="reserva" id="reserva" placeholder="Nº da Reserva" required>

            </div>
            <div class="col-sm-3">
              <label for="qtdcama" style='font-size: 11px;'> <strong>Cama Extra</strong></label>
              <select class="form-select" name="qtdcama" id="qtdcama" required>
                <option value="">Selecionar</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>

              </select>
            </div>
            <div class="col-sm-3">
              <label for="qtdberco" style='font-size: 11px;'> <strong>Berço</strong></label>
              <select class="form-select" name="qtdberco" id="qtdberco" required>
                <option value="">Selecionar</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>

              </select>
            </div>
           
            <div class="col-sm-3">
              <label for="checkin" style='font-size: 11px;'> <strong>Check-in</strong></label>
              <input type="date" class="form-control" name="checkin" id="checkin" placeholder="Check-in" required>

            </div>
            <div class="col-sm-3">
              <label for="checkout" style='font-size: 11px;'> <strong>Check-out</strong></label>
              <input type="date" class="form-control" name="checkout" id="checkout" placeholder="Check-out" required>

            </div>

            <div class="col-auto">
            <label for="pessoa" class="form-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#008000" class="bi bi-people" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>    
            <strong>Usuário:</strong> <?php echo $pessoa;?></label>
            </div>
              <br>
              <input type="submit" value="Gerar O.S." class="btn btn-outline-light" style="background-color: #b39464";>

          </form>
<?php
case 'Recepcao':
?>
          <br>
<center>
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-0">
<div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow"  style="width: 10rem;">
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
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
    <a href="camaextracontroleapp.php" class="link-underline-light">
        <center>
        <img src="imagens/camagov01.png" width="50">
        <br>
        <h7 class="card-title"> Controle </h7>
        </center>
    </a>
    </div>
  </div>
</div>

<?php 
    break;
  default:
  echo "&nbsp; &nbsp; <center><img src='imagens/permissao321.png' width='120px'><br>Usuário sem Permissão!</center>";
            break;
    }

} else {
  echo "Usuário não encontrado!";
}

  ?>
</center>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>