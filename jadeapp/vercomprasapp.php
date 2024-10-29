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
<label style="font-family: poppins";><p><b><img src="imagens/compras369.png" width="50"> &nbsp;&nbsp; CONTROLE DE COMPRAS</b></p></label>
<center>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-0">
    <?php
    include_once("connect_app2.php");

    $sql = "SELECT * FROM comprasapp WHERE status != 'PROCESSO FINALIZADO' ORDER BY `idcompras` DESC";

    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



switch($nivel){    

  case 'Admin':
  case 'Compras':

    foreach($result as $row){

echo '
      <div class="col">  
        <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow">
          <center>

            <table class="table" style="table-layout: fixed; word-wrap: break-word;">
              <thead>
                <tr class="table-warning">
                  <td colspan="3"><strong>Nº Pedido:</strong> &nbsp; '. $row['idcompras'] .'</td>             
                </tr>
              </thead>
              <tbody>
                <tr>
                <td colspan="3"><strong>Material:</strong> &nbsp; '. $row['material'] .'</td>
                </tr>
                <tr>
                  <td><strong>Setor:</strong> '. $row['setor_destino'] .'</td>
                  <td><strong>Empresa:</strong> '. $row['empresa'] .'</td>
                  <td><strong>Qtd:</strong> '. $row['quantidade'] .'</td>
                </tr>
                <tr>
                  <td colspan="3"><strong>Link:</strong> '; 
                  
                  if(isset($row['link']) && !empty($row['link'])){
                      echo'<a href="'.$row['link'].'" target="_blank">Click Aqui!</a>';
                  } else{
                    echo 'Não possui link!';
                  }

                  echo'</td>
                </tr>
                <tr>
                  <td colspan="3"><strong>Obs:</strong> '. $row['observacao'] .'</td>
                </tr>
                <tr>
                  <td><strong>Solicitante:</strong><br>'. $row['solicitante'] .'</td>
                  <td colspan="2"><strong>Data do pedido:</strong><br>'. $data_formatada = date('d/m/Y', strtotime($row['datapedido'])) .'</td>
                </tr>

                <tr>
                  <td colspan="3" style="background-color: #E6E6E6;">
';?>

<!-- SELEÇÕES -->
 <div>
<form method="POST" action="update_comprasapp.php">
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" value="1" id="nf" name="nf" <?php echo ($row['nf'] == 1) ? 'checked' : ''; ?>>
  <label class="form-check-label" for="nf">
    N.F.
  </label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" value="1" id="boleto" name="boleto" <?php echo ($row['boleto'] == 1) ? 'checked' : ''; ?>>
  <label class="form-check-label" for="boleto">
    Boleto
  </label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" value="1" id="em_pagamento" name="em_pagamento" <?php echo ($row['em_pagamento'] == 1) ? 'checked' : ''; ?>>
  <label class="form-check-label" for="em_pagamento">
    Enviado para Pagamento!
  </label>
</div>

<?php echo'
</td>
</tr>
<tr>
<td colspan="3" style="background-color: #E6E6E6;">

<div class="col">
<table>
<tr>
<td colspan="3" >
  <label for="status"> <strong>Status : &nbsp;</strong></label>
';

if($row['status'] == 'COTACAO'){
  echo '<strong style="color: #FF0000;">COTAÇÃO</strong>';

}else if($row['status'] == 'COMPRA REALIZADA'){
  echo '<strong style="color: #FFA500;">COMPRA REALIZADA!</strong>';

}else if($row['status'] == 'MATERIAL RECEBIDO'){
  echo '<strong style="color: #0000FF;">MATERIAL RECEBIDO!</strong>';

}else if($row['status'] == 'ENTREGUE AO SETOR'){
  echo '<strong style="color: #008000;">ENTREGUE AO SETOR!</strong>';

}else if($row['status'] == 'PROCESSO FINALIZADO'){
  echo '<strong style="color: #000000;">PROCESSO FINALIZADO!</strong>';

} else {
  echo '<strong style="color: #000000;">Aguardando!</strong>';

}

echo'</td></tr>

<tr><td colspan="2">';

        echo'<select class="form-select" name="status" id="status">';
       
        echo '<option value="'.$row['status'].'">'.$row['status'].'</option>';
        
        echo'
            <option value="COTACAO" style="color: #FF0000;">COTACAO</option>
            <option value="COMPRA REALIZADA" style="color: #FFA500;">COMPRA REALIZADA</option>
            <option value="MATERIAL RECEBIDO" style="color: #0000FF;">MATERIAL RECEBIDO</option>
            <option value="ENTREGUE AO SETOR" style="color: #008000;">ENTREGUE AO SETOR</option>
            <option value="PROCESSO FINALIZADO" style="color: #000000;">PROCESSO FINALIZADO</option>

    </select>
</td>
<td><input type="hidden" name="idcompras" value="'.$row['idcompras'].'">
<button type="submit" class="btn btn-primary">Atualizar</button></td>
</tr>
</table>
</div>
</form>
</div>

</td>
</tr>




<form method="POST" action="update_recebercompras.php">
<tr>
<td colspan="3">

<div class="col">
<table>
<tr>
<td>
    <label for="data_recebimento"><strong>Data de Recebimento: &nbsp;</strong></label>
</td>
</tr>
<tr>
<td>
    <input type="date" class="form-control" name="data_recebimento" id="data_recebimento" value="'.$row['data_recebimento'].'">
</td>
<td>
    <input type="hidden" name="idcompras" value="'.$row['idcompras'].'">
    <button type="submit" class="btn btn-warning">Receber!</button>
</td>

</tr>
</table>
</div>

</td>
</tr>
</form>



<!-- FIM SELEÇÕES -->

                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <center>
                      <a href="#" onclick="confirmDeletion(' . $row['idcompras'] . ')">
                        <img src="imagens/excluirreg1.png" width="30">
                      </a>
                    </center>
                  </td>
                </tr>
              </tbody>
            </table>
            


          </center>
        </div>
      </div>';

}
  
break;
/////////////////////////
case 'Gerencia':
case 'Manutencao':

    foreach($result as $row){

      echo '
            <div class="col">  
              <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow">
                <center>
      
                  <table class="table" style="table-layout: fixed; word-wrap: break-word;">
                    <thead>
                      <tr class="table-warning">
                        <td colspan="3"><strong>Nº Pedido:</strong> &nbsp; '. $row['idcompras'] .'</td>             
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      <td colspan="3"><strong>Material:</strong> &nbsp; '. $row['material'] .'</td>
                      </tr>
                      <tr>
                        <td><strong>Setor:</strong> '. $row['setor_destino'] .'</td>
                        <td><strong>Empresa:</strong> '. $row['empresa'] .'</td>
                        <td><strong>Qtd:</strong> '. $row['quantidade'] .'</td>
                      </tr>
                      
                      <tr>
                        <td><strong>Solicitante:</strong><br>'. $row['solicitante'] .'</td>
                        <td colspan="2"><strong>Data do pedido:</strong><br>'. $data_formatada = date('d/m/Y', strtotime($row['datapedido'])) .'</td>
                      </tr>
      
                      <tr>
                        <td colspan="3" style="background-color: #E6E6E6;">
      ';?>
      
     
      <?php echo'
      </td>
      </tr>
      <tr>
      <td colspan="3" style="background-color: #E6E6E6;">
      
      <div class="col">
      <table>
      <tr>
      <td colspan="3" >
        <label for="status"> <strong>Status : &nbsp;</strong></label>
      ';
      
      if($row['status'] == 'COTACAO'){
        echo '<strong style="color: #FF0000;">COTAÇÃO</strong>';
      
      }else if($row['status'] == 'COMPRA REALIZADA'){
        echo '<strong style="color: #FFA500;">COMPRA REALIZADA!</strong>';
      
      }else if($row['status'] == 'MATERIAL RECEBIDO'){
        echo '<strong style="color: #0000FF;">MATERIAL RECEBIDO!</strong>';
      
      }else if($row['status'] == 'ENTREGUE AO SETOR'){
        echo '<strong style="color: #008000;">ENTREGUE AO SETOR!</strong>';
      
      }else if($row['status'] == 'PROCESSO FINALIZADO'){
        echo '<strong style="color: #000000;">PROCESSO FINALIZADO!</strong>';
      
      } else {
        echo '<strong style="color: #000000;">Aguardando!</strong>';
      
      }
      
      echo'</td></tr>
      </table>
      </div>
      </table>
    </center>
  </div>
</div>';

    }
    

break;

default:

    echo "<center><img src='imagens/permissao321.png' width='120px'><br>Usuário sem Permissão!</center>";
    }
  
?>
</div>
</center>
<!-- script complementa o onclick do botão de excluir! -->
<script>
    function confirmDeletion(id) {
        if (confirm('Você realmente quer excluir?')) {
            window.location.href = 'deletecompras.php?idcompras=' + id;
        }
    }
</script>
<!-- Fim do script botão excluir -->


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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>