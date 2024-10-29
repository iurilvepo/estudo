<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
    exit();
  }

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
$nomeUsuario = $_SESSION['nome']; // Substitua pelo nome do usuário atual
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
<label style="font-family: poppins";><p><b><img src="imagens/solicitarcomp231.png" width="50"> &nbsp;&nbsp; COMPRAS</b></p></label>
 
<?php if ($nivel) { 
  
  switch ($nivel) {
    case 'Admin':
    case 'Gerencia':
    case 'Compras':
    case 'Manutencao':
   
    ?>
          <form class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-0 gy-2 align-items-center" action="enviarcompraapp.php" method="post">

            <div class="col">
              <label for="material" style='font-size: 11px;'> <strong>Material</strong></label>
              <input type="text" class="form-control" name="material" id="material" placeholder="Nome do produto" required>

            </div>
            <div class="col">
              <label for="qtd" style='font-size: 11px;'> <strong>Quantidade</strong></label>
              <select class="form-select" name="qtd" id="qtd" required>
                <option value="">Selecionar</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>

              </select>
            </div>

            <div class="col">
              <label for="empresa" style='font-size: 11px;'> <strong>Empresa</strong></label>
              <select class="form-select" name="empresa" id="empresa" required>
                <option value="">Selecionar</option>
                    <option value="Hotel">Hotel</option>
                    <option value="Condominio">Condominio</option>
                    <option value="Subcondominio">Subcondominio</option>
       

              </select>
            </div>

            <div class="col">
              <label for="setor_destino" style='font-size: 11px;'> <strong>Setor</strong></label>
              <select class="form-select" name="setor_destino" id="setor_destino">
                <option value="">Selecionar</option>
                    <option value="TI">TI</option>
                    <option value="Comercial">Comercial</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Faturamento">Faturamento</option>
                    <option value="Eventos">Eventos</option>
                    <option value="Recepcao Hotel">Recepção Hotel</option>
                    <option value="Recepcao Office">Recepção Office</option>
                    <option value="RH">RH</option>
                    <option value="Manutencao">Manutenção</option>
                    <option value="Governanca">Governança</option>
                    <option value="Almoxarifado">Almoxarifado</option>
                    <option value="Gerencia">Gerência</option>
                    <option value="Garagem Rotativo">Garagem Rotativo</option>
                    <option value="Outro">Outro</option>

              </select>
            </div>

            <div class="col">
              <label for="link" style='font-size: 11px;'> <strong>Link</strong></label>
              <input type="text" class="form-control" name="link" id="link" placeholder="Link da pagina web">

            </div>
            <div class="col">
              <label for="observacao" style='font-size: 11px;'> <strong>Observação</strong></label>
              <input type="text" class="form-control" name="observacao" id="observacao" placeholder="Observações digite aqui!">

            </div>

            <div class="col">
             
            </div>

            <div class="col">
            <label for="pessoa" class="form-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#008000" class="bi bi-people" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>    
            <strong>Usuário:</strong> <?php echo $pessoa;?></label>
            </div>
                <div class="col">
                <!-- vazio para organização! -->
                </div>
            <br>
            <input type="submit" value="Solicitar Compra!" class="btn btn-outline-light" style="background-color: #b39464";>

          </form>
          <br>

<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-0">
    <div class="col">  
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
            <a href="comprasapp.php" class="link-underline-light">
                <center>
                <img src="imagens/voltaricon.png" width="50">
                <br>
                <h7 class="card-title"> Voltar </h7>
                </center>
            </a>
        </div>
    </div>
</div>
<?php 
    break;
  default:
            echo "<center><img src='imagens/permissao321.png' width='120px'><br>Usuário sem Permissão!</center>";
            break;
    }

} else {
  echo "Usuário não encontrado!";
}

  ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>