<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

$nivel = $_SESSION['nivel'];

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
<label style="font-family: poppins";><b><p><img src="imagens/arcond002.png" width="50"> &nbsp;&nbsp; Ar-Condicionado</p></b></label>

<table class="table">
    <thead>
        <tr class="table-warning">
            <th scope="col">Apartamento</th>
            <th scope="col"></th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

<?php
include_once("connect_app2.php");

//FIELD ordena por 
$sql = "SELECT * FROM arcondicionadoapp ORDER BY FIELD(tipostatus, 'Preventiva', 'Corretiva', 'Pendente', 'Executado')";

$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){

    if($row['tipostatus'] !== "Concluido"){

    echo'
    <tr class="table-group-divider">
    <td colspan="2">'.$row['apartamento'].'</td>
    <td style="font-size: 12px;">
    ';
    
    if($row['tipostatus'] == "Pendente"){
        echo"<img src='imagens/priorityalta1.png' width='80'>";

    } elseif($row['tipostatus'] == "Preventiva"){
        echo"<img src='imagens/prioritynormal1.png' width='80'>";
    
    } elseif($row['tipostatus'] == "Corretiva"){
        echo"<img src='imagens/prioritypendente1.png' width='80'>";

    } elseif($row['tipostatus'] == "Executado"){
        echo"<img src='imagens/priorityexecutado1.png' width='80'>";

    } elseif($row['tipostatus'] == "Concluido"){
        echo"<img src='imagens/priorityconcluido1.png' width='80'>";
    } else{
        echo"Não Especificado!";
    }

    echo'
    </td>
    </tr>

    <tr>
        <td colspan="2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFA500" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
        </svg>
        &nbsp; 
        <strong>Observação:</strong>
        <br>
        '.$row['observacao'].'
        </td>
        <td><center><a href="alterararcondicionado.php?idarc='.$row['idarc'].'"><img src="imagens/status11.png" width="35"></a>&nbsp;&nbsp;';
   
        if($nivel == "Gerencia" || $nivel == "Manutencao" || $nivel == "Admin"){ 

        echo '<a href="#" onclick="confirmDeletion('.$row['idarc'].')"><img src="imagens/excluirreg1.png" width="35"></a>'; 
        }
        echo'</center></td></tr>';
//Link para alterararcondicionado.php com a id do registro!!
    } //fim do if
}

?>

<!-- script complementa o onclick do botão de excluir! -->
<script>
    function confirmDeletion(id) {
        if (confirm('Você realmente quer excluir este registro?')) {
            window.location.href = 'deletearcondicionado.php?idarc=' + id;
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
        <a href="inicial.php" class="link-underline-light">
            <center>
            <img src="imagens/voltaricon.png" width="50">
            <br>
            <h7 class="card-title"> Voltar </h7>
            </center>
        </a>
    </div>
  </div>
</div>
</center>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>