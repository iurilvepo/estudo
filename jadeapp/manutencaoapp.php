<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

$pessoa = $_SESSION['nome'];
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

<label style="font-family: poppins";><p><b><img src="imagens/iconmanutencao.png" width="50"> &nbsp;&nbsp; Gerar Ordem de Serviço</b></p></label>
  
          <form class="row g-0 gy-2 align-items-center" action="addarcondicionado.php" method="post">

            <div class="col-sm-3">
              <label for="apartamento" style='font-size: 11px;'> <strong>Apartamento</strong></label>
              <select class="form-select" name="apartamento" id="apartamento" required>
                <option value="">Selecionar</option>

<?php
include('connect_app2.php');

$sql = "SELECT * FROM apartamentoapp  ORDER BY idapartamento ASC";

$stmt = $pdo->query($sql);
$result= $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){
?>                
                <option value="<?php echo $row['apartamento'];?>"><?php echo $row['apartamento'];?></option>
<?php }?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="bloco" style='font-size: 11px;'> <strong>Bloco</strong></label>
              <select class="form-select" name="bloco" id="bloco" required>
                <option value="">Selecionar</option>
<?php
               echo' <option value="A">A</option>';
               echo' <option value="B">B</option>';
               echo' <option value="C">C</option>';
 ?>
              </select>
            </div>
            <div class="col-sm-3">
              <label for="tipostatus" style='font-size: 11px;'> <strong>Status</strong></label>
              <select class="form-select" name="tipostatus" id="tipostatus" required>
                <option value="">Selecionar</option>
                <option value="Preventiva" style="color:#B8860B">Preventiva</option>
                <option value="Corretiva" style="color:#8B4513">Corretiva</option>

              </select>
            </div>
           
            <div class="mb-3">
              <label for="observacao" class="form-label" style='font-size: 11px;'><strong>Observações:</strong></label>
              <textarea class="form-control" name="observacao" id="observacao" rows="3"></textarea>
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
    <a href="arcondicionadoapp.php" class="link-underline-light">
        <center>
        <img src="imagens/arcond002.png" width="50">
        <br>
        <h7 class="card-title"> O.S. Abertas </h7>
        </center>
    </a>
    </div>
  </div>
</div>
</center>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>