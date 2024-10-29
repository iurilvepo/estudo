<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
    exit();
}

$pessoa = $_SESSION['nome'];
$nivel = $_SESSION['nivel'];

$idarc = filter_input(INPUT_GET, 'idarc', FILTER_SANITIZE_NUMBER_INT);

include_once('connect_app2.php');

$sql = "SELECT * FROM arcondicionadoapp WHERE idarc = :idarc";
$stmt = $pdo->prepare($sql);
$stmt -> bindParam(':idarc', $idarc, PDO::PARAM_INT);
$stmt -> execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$result){
  echo "Registro não encontrado!";
  exit();
}

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
<label style="font-family: poppins";><b><p><img src="imagens/status11.png" width="50"> &nbsp;&nbsp; Ar-Condicionado (STATUS) </p></b></label>

          <form class="row g-3 gy-2 align-items-center" action="atualizarar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idarc" value="<?php echo $result['idarc']; ?>">

            <div class="col-sm-3">
            <p class="form-label" style="text-align: right;"><img src="imagens/setahome123.png" width="30">&nbsp;<strong><?php echo $result['apartamento'];?></strong>&nbsp;&nbsp;</p>
            </div>

            <div class="col-sm-3">
              <label class="form-label" for="tipostatus">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#DAA520" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
              </svg> 
              <strong>Status</strong></label>
              <select class="form-select" name="tipostatus" id="tipostatus">
                <option value="<?php echo $result['tipostatus'];?>"><?php echo $result['tipostatus'];?></option>
                <option value="Pendente" style="color:#DAA520">Pendente</option>
                <option value="Executado" style="color:#ED9121">Executado</option>

                <?php if($nivel == "Manutencao" || $nivel == "Admin"){  ?>
                <option value="Concluido" style="color:#008000">Concluido</option>
                <?php }?>

              </select>
            </div>

            <?php if($nivel == "Prestador" || $nivel == "Admin"){  ?>
            <div class="col-sm-3">
              <label class="form-label" for="servico">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/>
                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/>
              </svg> 
              <strong>Serviço</strong></label>
              <select class="form-select" name="servico" id="servico">
                <option selected><?php echo $result['servico'];?></option>
         
                <?php
                //aki só vai exibir as opções de serviços cadastrados para uso!
                $sql2 = "SELECT * FROM tiposervicosapp ORDER BY tiposervico ASC";
                $stmt2 = $pdo->query($sql2);
                $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                foreach($result2 as $row2){
                echo'<option value="'. $row2["tiposervico"] .'">'. $row2["tiposervico"] .'</option>';
                }
                ?>

              </select>
            </div>
            
            <?php } else {
              echo'<div class="col-sm-3">
              <label class="form-label" for="servico">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/>
                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/>
              </svg> 
              <strong>Serviço</strong></label>
              <br>';
              if(isset($result['servico'])){
                echo $result['servico'];
              }else {
                echo'À informar!';
              }
              echo'</div>';
            }?>

<?php if($nivel == "Prestador" || $nivel == "Admin"){  ?>
      <div class="col-sm-3">
            <label class="form-label" for="imagem">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6A5ACD" class="bi bi-images" viewBox="0 0 16 16">
              <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
              <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z"/>
            </svg>
                <strong>Imagem</strong></label>
            <input class="form-control" type="file" name="imagem" id="imagem">
            <br>
           <?php if(isset($result['imagem'])){
            echo '<a href="uploads/'. $result['imagem'] .'" target="_blank"><img src="imagens/imganexo.png" width="30"></a>';
          }else {
            echo'Sem imagem!';
          }?>
        </div>
<?php } else {

          echo'<div class="col-sm-3">
            <label class="form-label" for="imagem">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6A5ACD" class="bi bi-images" viewBox="0 0 16 16">
              <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
              <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z"/>
            </svg>
                <strong>Imagem</strong></label>
                <br>';
          if(isset($result['imagem'])){
            echo '<a href="uploads/'. $result['imagem'] .'" target="_blank"><img src="imagens/imganexo.png" width="30"></a>';
          }else {
            echo'Sem imagem!';
          }
          echo'</div>';
}?>

        <?php if($nivel == "Gerencia" || $nivel == "Manutencao" || $nivel == "Admin"){  ?>
          <div class="mb-3">
            <table>
              <tr>
                <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FF0000" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                </svg>
                &nbsp; 
                <strong>Observações Técnicas:</strong>
                <br>
                <?php
                if(isset($result['observacaotec'])){
                    echo $result['observacaotec'];
                  }else {
                    echo'À informar!';
                  }
                  ?>
                </td>
              </tr>
            </table>
          </div>
            <div class="mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
            </svg>
            &nbsp; 
              <label for="observacao" class="form-label"><strong>Observações:</strong></label>
              <textarea class="form-control" name="observacao" id="observacao" rows="3"><?php echo $result['observacao'];?></textarea>
            </div>
        <?php }elseif ($nivel == "Prestador") {?>
          <div class="mb-3">
            <table>
              <tr>
                <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FF0000" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                </svg>
                &nbsp; 
                <strong>Observações:</strong>
                <br>
                <?php echo $result['observacao'];?>
                </td>
              </tr>
            </table>
          </div>

            <div class="mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text-fill" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
            </svg>
            &nbsp; 
              <label for="observacaotec" class="form-label"><strong>Observação Técnica:</strong></label>
              <textarea class="form-control" name="observacaotec" id="observacaotec" rows="3"><?php echo $result['observacaotec'];?></textarea>
            </div>
        <?php }?>

            <div class="col-auto">
            <label for="pessoa" class="form-label">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#008000" class="bi bi-people" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
            </svg>    
            <strong>Usuário:</strong> <?php echo $pessoa;?></label>
            </div>
              <br>
              <input type="submit" value="Alterar Status!" class="btn btn-outline-light" style="background-color: #b39464";>
            
          </form>

          <br>
<div class="row">

<div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow">
    <a href="arcondicionadoapp.php" class="link-underline-light">
        <center>
        <img src="imagens/voltaricon.png" width="50">
        <br>
        <h7 class="card-title"> Voltar </h7>
        </center>
    </a>
    </div>
  </div>

  <div class="col">  
    <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>