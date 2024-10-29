<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

?>

<!DOCTYPE html">
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
<label style="font-family: poppins";><b><p>Usuários Cadastrados</p></b></label>

<table class="table">
  <thead>
    <tr class="table-warning">
      <th scope="col">Nome</th>
      <th scope="col">Nível</th>
      <th scope="col">Opção</th>
    </tr>
  </thead>
  <tbody>

<?php
include_once("connect_app2.php");

$sql = "SELECT * FROM loginapp ORDER BY `idlogin` DESC";

$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){
echo"<tr class='table-group-divider'>
      <td>".$row['nome']."</td>
      <td style='font-size: 9px;'>"; 
      
      if($row['nivel'] == 'Admin'){
        echo'<img src="imagens/admin001.png" width="25">';
      } else if($row['nivel'] == 'Gerencia'){
        echo'<img src="imagens/coroa001.png" width="25">';
      } else if($row['nivel'] == 'Manutencao'){
        echo'<img src="imagens/manu001.png" width="25">';
      } else if($row['nivel'] == 'Recepcao'){
        echo'<img src="imagens/iconrecepcao1.png" width="25">';
      } else if($row['nivel'] == 'Prestador'){
        echo'<img src="imagens/terc001.png" width="25">';
      } else if($row['nivel'] == 'Compras'){
          echo'<img src="imagens/solicitarcomp231.png" width="25">';
      } else { echo'N/A';}
      echo "&nbsp;".$row['nivel']; 
   
      echo"</td>
      <td></td>
     </tr>
     <tr>
     <td colspan='2'><img src='imagens/emailremessa2.png' width='30'> ".$row['email']."</td>
     <td><center><a href='#' onclick='confirmDeletion(".$row['idlogin'].")'><img src='imagens/excluirreg1.png' width='30'></a></center></td>
     </tr>";
}

?>

<!-- script complementa o onclick do botão de excluir! -->
<script>
    function confirmDeletion(id) {
        if (confirm('Você realmente quer excluir este usuário?')) {
            window.location.href = 'deleteusuario.php?idlogin=' + id;
        }
    }
</script>
<!-- Fim do script botão excluir -->

</tbody>
</table>
<br>

<center>
<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-0">
<div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
    <a href="usuarioapp.php" class="link-underline-light">
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
    <a href="inicial.php" class="link-underline-light">
        <center>
        <img src="imagens/home061.png" width="50">
        <br>
        <h7 class="card-title"> Home </h7>
        </center>
    </a>
    </div>
  </div>
</div>
</center>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>