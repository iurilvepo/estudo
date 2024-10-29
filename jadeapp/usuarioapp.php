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
<label style="font-family: poppins";></div><b><p><img src="imagens/addpessoas.png" width="40"> &nbsp;&nbsp; Cadastro de Usuário</p></b></label>

<form class="row g-0 gy-2 align-items-center" action="addusuario.php" method="post">
  <div class="col-sm-3">
    <label class="visually-hidden" for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
  </div>

  <div class="col">
    <label class="visually-hidden" for="email">E-Mail</label>
    <div class="input-group">
      <div class="input-group-text">@</div>
      <input type="email" class="form-control" name="email" id="email" placeholder="E-Mail">
    </div>
  </div>

  <div class="col-sm-3">
    <label class="visually-hidden" for="nivel">Nível</label>
    <select class="form-select" name="nivel" id="nivel">
      <option selected>Níveis de Acesso...</option>
      <?php
      include('connect_app2.php');

      $sql = "SELECT * FROM nivelusuarioapp ORDER BY `idnivel` ASC";

      $stmt = $pdo->query($sql);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach($result as $row){
      ?>
      <option value="<?php echo $row['nivel'];?>"><?php echo $row['nivel'];?></option>
      <?php }?>
    </select>
  </div>
  
  <div class="col-sm-3">
    <label class="visually-hidden" for="senha">Senha</label>
    <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
  </div>


<br>
	<input type="submit" value="Cadastrar!" class="btn btn-outline-light" style="background-color: #b39464";>

</form>
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

  <div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow" style="width: 10rem;">
    <a href="listausuariosapp.php" class="link-underline-light">
        <center>
        <img src="imagens/listauser1.png" width="50">
        <br>
        <h7 class="card-title"> Usuários </h7>
        </center>
    </a>
    </div>
  </div> 
</div>
</center>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>