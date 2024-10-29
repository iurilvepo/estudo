<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idlogin'])) {
    header("location: index.php");
    exit;
} else {
    $nivel = $_SESSION['nivel'];
}

// Inclui o arquivo de conexão com o banco de dados.
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




// Verifica se foi enviado um mês e ano via POST
if (isset($_POST['mes']) && isset($_POST['ano'])) {
    $mes = (int)$_POST['mes'];
    $ano = (int)$_POST['ano'];
} else {
    // Se não foi enviado, usa o mês e ano atual
    $mes = date('n');
    $ano = date('Y');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Jade</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #d9ead3;
        }
        td {
            background-color: #fff;
        }
        @media (max-width: 600px) {
            th, td {
                padding: 10px;
                font-size: 12px;
            }
        }
        #calendario-container {
            margin-top: 20px;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .icon-svg {
            fill: #B8C5C0;
            transition: fill 0.3s ease;
        }

        .icon-svg:hover {
            fill: #2F4F4F;
        }

    </style>

<style>
        /* Estilo para o fundo quando o pop-up está aberto */
        #popup {
            display: none; /* Esconde o pop-up por padrão */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fundo transparente escuro */
            justify-content: center;
            align-items: center;
        }
        
        /* Estilo para o conteúdo do pop-up */
        #popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        /* Botão para fechar o pop-up */
        .close-btn {
            background-color: #FE2E2E;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #0174DF;
        }
    </style>
</head>
<body>

<label style="font-family: poppins;"><b><p><img src="imagens/camagov01.png" width="50"> &nbsp;&nbsp; Controle de Camas Extra</p></b></label>

<!-- Formulário para seleção do mês e ano -->
<div class='registro-card' style='padding: 1px; margin-bottom: 5px;'>

    <form method="POST" action="">
        <div class='registro-header' style='display: flex; align-items: center;'>
            <img src="imagens/calen234.png" width="25px"> 
            <div style='flex-grow: 0; margin-left: 5px;'>
                <select name="mes" class="form-select form-select-sm">
                    <?php
                    // Gera as opções do mês, com o mês atual selecionado
                    $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
                    for ($m = 1; $m <= 12; $m++) {
                        $selected = ($mes == $m) ? 'selected' : '';
                        echo "<option value='$m' $selected>{$meses[$m-1]}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div style='flex-grow: 0; margin-left: 5px;'>
                <select name="ano" class="form-select form-select-sm">
                    <?php
                    // Gera as opções de ano, com o ano atual selecionado
                    for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
                        $selected = ($ano == $i) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div style='flex-grow: 1; margin-left: 2px;'>
                <button type="submit" class="btn btn-link">
                   <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="icon-svg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
                   </svg>
                </button>
            </div>
        </div>
    </form>
</div>


<?php
// Função para criar o calendário com base no mês e ano selecionado
function criarCalendarioMensalPorSemana($pdo, $mes, $ano) {
    $diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

    // Array com os nomes dos meses abreviados em português
    $mesesAbreviados = [
        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 
        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 
        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
    ];

    // Obter o primeiro e o último dia do mês selecionado
    $primeiroDiaDoMes = mktime(0, 0, 0, $mes, 1, $ano);
    $ultimoDiaDoMes = mktime(0, 0, 0, $mes + 1, 0, $ano);

    // Calcular o número de dias no mês
    $diasNoMes = date('t', $primeiroDiaDoMes);

    // Encontrar o índice do primeiro dia da semana (0 = Domingo, 6 = Sábado)
    $diaDaSemanaPrimeiroDia = date('w', $primeiroDiaDoMes);

    // Inicializando o contador de dias
    $diaAtual = 1 - $diaDaSemanaPrimeiroDia;

    // Exibir o calendário semana por semana
    while ($diaAtual <= $diasNoMes || $diaDaSemanaPrimeiroDia > 0) {
        echo "<div class='registro-card' style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin-bottom: 10px; background-color: #f9f9f9;'>";
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th style='padding: 0px;'>$ano</th>"; // Coluna extra à esquerda

        // Cabeçalho com os dias da semana
        foreach ($diasDaSemana as $dia) {
            echo "<th style='padding: 0px;'>$dia</th>";
        }

        echo "</tr><tr>";

        // Exibir a coluna extra e cada dia da semana
        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                echo "<td style='padding: 0px; font-size: 10px;'><strong><br>Dias
                <div class='text-success'>
                <hr>
                </div>Cama: 42
                <div class='text-success'>
                <hr>
                </div><p>Berço: 4</p></strong></td>"; // Coluna extra
            }

            if ($diaAtual <= 0) {
                // Exibir dias do mês anterior
                $mesAnterior = $mes - 1;
                $anoAnterior = $ano;
                if ($mesAnterior == 0) {
                    $mesAnterior = 12;
                    $anoAnterior--;
                }
                $diaMesAnterior = date('j', mktime(0, 0, 0, $mesAnterior, $diaAtual, $anoAnterior));
                $mesNomeAbreviado = $mesesAbreviados[$mesAnterior];
                echo "<td style='padding: 0px; text-align: center; color: #999; font-size: 10px;'>$diaMesAnterior&nbsp;$mesNomeAbreviado</td>";
            } elseif ($diaAtual > $diasNoMes) {
                // Exibir dias do próximo mês
                $mesProximo = $mes + 1;
                $anoProximo = $ano;
                if ($mesProximo > 12) {
                    $mesProximo = 1;
                    $anoProximo++;
                }
                $diaMesProximo = date('j', mktime(0, 0, 0, $mesProximo, $diaAtual - $diasNoMes, $anoProximo));
                $mesNomeAbreviado = $mesesAbreviados[$mesProximo];
                echo "<td style='padding: 0px; text-align: center; color: #999; font-size: 10px;'>$diaMesProximo&nbsp;$mesNomeAbreviado</td>";
            } else {

                // Verificar reservas na data atual
        $dataAtual = sprintf('%04d-%02d-%02d', $ano, $mes, $diaAtual);
        $stmt = $pdo->prepare("SELECT * FROM camaextraapp WHERE checkin <= :dataAtual AND checkout >= :dataAtual");
        $stmt->bindParam(':dataAtual', $dataAtual);
        $stmt->execute();
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Inicializar os acumuladores de camas e berços
        $totalCamas = 0;
        $totalBercos = 0;
    
        foreach ($reservas as $reserva) {
            // Acumular o valor de camas e berços
            $totalCamas += $reserva['qtdcama'];
            $totalBercos += $reserva['qtdberco'];
        }
                // Exibir dias do mês atual
                $dataAtual = mktime(0, 0, 0, $mes, $diaAtual, $ano);
                $diaMes = date('j', $dataAtual);
                $mesAbreviado = $mesesAbreviados[$mes]; // Retorna Jan, Feb, Mar, etc.
                echo "<td style='padding: 0px; text-align: center; font-size: 10px;'><strong style='color: #006400;';><br>$diaMes&nbsp;$mesAbreviado</strong> 
                <div class='text-success'>
                <hr>
                </div>";
                $valorcamas = (42-$totalCamas);
                if($valorcamas <= 0){
                    echo "<strong style='color: #ec2300;'>". $valorcamas ."</strong>";
                }else{
                    echo "<strong>". $valorcamas ."</strong>";
                }
            
                echo"<div class='text-success'>
                <hr>
                </div><p>";
                $valorbercos = (4-$totalBercos);
                if($valorbercos <= 0){
                    echo "<strong style='color: #ec2300;'>". $valorbercos ."</strong>";
                }else{
                    echo "<strong>". $valorbercos ."</strong>";
                }
                
                echo"</p></td>";
            }

            $diaAtual++;
        }

        echo "</tr>";

        echo "</table>";
        echo "</div>";

        $diaDaSemanaPrimeiroDia = 0; // Reiniciar o primeiro dia da semana para os próximos ciclos
    }
}

################################aki começa a LISTA#############################

// Gerar a lista de registros abaixo do calendário
$stmt = $pdo->query("SELECT * FROM camaextraapp ORDER BY checkout ASC");
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iniciar a lista de registros
$listaRegistros = "<h3>Lista de Registros:</h3>";

foreach ($registros as $registro) {

if ($registro['devolucao'] == 0) {
    $listaRegistros .= "
<div class='registro-card' style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin-bottom: 10px; background-color: #f9f9f9;'>
        <div class='registro-header' style='display: flex; align-items: center;'>
            <img src='imagens/setahome123.png' width='30' alt='Seta'>
            <div style='flex-grow: 1; margin-left: 10px;'>
                <strong>Reserva:</strong> " . htmlspecialchars($registro['reserva']) . "
            </div>
        </div>

    <div class='registro-header' style='display: flex; align-items: center;'>
        <div style='flex-grow: 1; margin-left: 40px;'>
            <div style='font-size: 11px;'><strong>Qtd. Camas:</strong> " . htmlspecialchars($registro['qtdcama']) . "</div>
            <div style='font-size: 11px;'><strong>Qtd. Berços:</strong> " . htmlspecialchars($registro['qtdberco']) . "</div>
        </div>
        <div style='flex-grow: 2; margin-left: 20px;'>
            <div style='font-size: 11px;'><strong>Check-in:</strong> " . date('d/m/Y', strtotime($registro['checkin'])) . "</div>
            <div style='font-size: 11px;'><strong>Check-out:</strong> " . date('d/m/Y', strtotime($registro['checkout'])) . "</div>
        </div>
    </div>
<br>";

// Verificação de nível de acesso
if ($nivel) {
    switch ($nivel) {
        case 'Admin':
            $listaRegistros .= "
        <div class='container' style='margin-left: 0px;'>
        <div class='row'>
        <div class='col-md-5 col-12'>
        <div class='p-3 mb-3 bg-success text-white'>
<div class='container text-center'>
  <div class='row'>
    <div class='col-3'>
            <img src='imagens/camareira12.png' width='30px'>
</div>
<div class='col-6'>        

            <form class='row g-0 gy-2 align-items-center' action='montarcamaapp.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='idcama' value='" . htmlspecialchars($registro['idcama']) . "'>
            <input type='hidden' name='quarto' value='" . htmlspecialchars($registro['quarto']) . "'>

                <select class='form-select form-select-sm' name='camamontada' aria-label='Small select example'>
                    <option selected>". ($registro['camamontada'] == '0' ? 'Não' : 'Sim') ."</option>
                    <option value='0'>Não</option>
                    <option value='1'>Sim</option>
                </select>
 </div>
<div class='col-2'>         

          
                <button type='submit' class='btn btn-link' onclick='return confirm(\"Montar Cama?\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='icon-svg' viewBox='0 0 16 16'>
                    <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                    <path d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z'/>
                    </svg>
                </button>  
                </form>
    </div>
  </div>
</div>

                </div></div>
                ";


    $listaRegistros .= " 
    
        <div class='col-md-5 col-12'>
        <div class='p-3 mb-3 bg-success text-white'>

<div class='container text-center'>
  <div class='row'>
    <div class='col-3'>
        <img src='imagens/marcadortitulo1.png' width='35' alt='Seta'> 
</div>
<div class='col-6'>
    <form class='row g-0 gy-2 align-items-center' action='vincularquartoapp.php' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='idcama' value='" . htmlspecialchars($registro['idcama']) . "'>

        <select class='form-select form-select-sm' name='quarto' aria-label='Small select example'>
            <option selected>". htmlspecialchars($registro['quarto']) ."</option>
            ";

        $sql2 = "SELECT * FROM apartamentocamaextra ORDER BY idapartamento ASC";
        $stmt2 = $pdo->query($sql2);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach($result2 as $row2){
            $listaRegistros .= "<option value='". htmlspecialchars($row2['apartamento']) ."'>". htmlspecialchars($row2['apartamento']) ."</option>";

        }

        $listaRegistros .= "
        </select>
</div>
<div class='col-2'>
        <button type='submit' class='btn btn-link' onclick='return confirm(\"Vincular Quarto?\")'>
            <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='icon-svg' viewBox='0 0 16 16'>
            <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
            <path d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z'/>
            </svg>
        </button>
                
        </form>
        </div>
      </div>
     </div>
   </div>
 </div>
</div>
<strong>Cama Montada: </strong> ".
    ($registro['camamontada'] == '0' ? '<img src="imagens/esferavermok.png" width="15px">':'<img src="imagens/esferaverdeok.png" width="15px">')
."</div>

    <center>
    <br>
    <div class='registro-actions' style='display: flex; align-items: center; justify-content: flex-end;'>
              
    <button type='button' onclick='openPopup(
        `" . htmlspecialchars($registro['reserva']) . "`,
        `" . htmlspecialchars($registro['qtdcama']) . "`,
        `" . htmlspecialchars($registro['qtdberco']) . "`,
        `" . htmlspecialchars($registro['checkin']) . "`,
        `" . htmlspecialchars($registro['checkout']) . "`
    )' class='btn btn-outline-primary'>
        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
        </svg> Alterar
    </button>
                      
                &nbsp;
                <a href='devolvercamaapp.php?excluir_idcama=" . htmlspecialchars($registro['idcama']) . "' onclick='return confirm(\"Tem certeza que deseja DEVOLVER?\")'>
                    <button type='button' class='btn btn-outline-primary'>
                        <svg xmlns=http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-reply-all' viewBox='0 0 16 16'>
                        <path d='M8.098 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.7 8.7 0 0 0-1.921-.306 7 7 0 0 0-.798.008h-.013l-.005.001h-.001L8.8 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L4.114 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028zM9.3 10.386q.102 0 .223.006c.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96z'/>
                        <path d='M5.232 4.293a.5.5 0 0 0-.7-.106L.54 7.127a1.147 1.147 0 0 0 0 1.946l3.994 2.94a.5.5 0 1 0 .593-.805L1.114 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028 4.012-2.954a.5.5 0 0 0 .106-.699'/>
                        </svg> Devolver
                    </button>
                </a>
    
    </div>
    </center>";
    
break;


case 'Gerencia':

    $listaRegistros .= "
    <div class='container' style='margin-left: 0px;'>
    <div class='row'>
    <div class='col-md-5 col-12'>
    <div class='p-3 mb-3 bg-success text-white'>
<div class='container text-center'>
<div class='row'>
<div class='col-3'>
        <img src='imagens/camareira12.png' width='30px'>
</div>
<div class='col-6'>        

        <form class='row g-1 gy-2 align-items-center' action='montarcamaapp.php' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='idcama' value='" . htmlspecialchars($registro['idcama']) . "'>
        <input type='hidden' name='quarto' value='" . htmlspecialchars($registro['quarto']) . "'>

            <select class='form-select form-select-sm' name='camamontada' aria-label='Small select example'>
                <option selected>". ($registro['camamontada'] == '0' ? 'Não' : 'Sim') ."</option>
                <option value='0'>Não</option>
                <option value='1'>Sim</option>
            </select>
</div>
<div class='col-2'>         
      
            <button type='submit' class='btn btn-link' onclick='return confirm(\"Montar Cama?\")'>
                <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='icon-svg' viewBox='0 0 16 16'>
                <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                <path d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z'/>
                </svg>
            </button>  
            </form>
        </div>
    </div>
</div>
</div>
</div>";

$listaRegistros .= "  
</div>
<strong>Cama Montada: </strong> ".
($registro['camamontada'] == '0' ? '<img src="imagens/esferavermok.png" width="15px">':'<img src="imagens/esferaverdeok.png" width="15px">')
."</div>

<center>
<br>
<div class='registro-actions' style='display: flex; align-items: center; justify-content: flex-end;'>
          
<button type='button' onclick='openPopup(
    `" . htmlspecialchars($registro['reserva']) . "`,
    `" . htmlspecialchars($registro['qtdcama']) . "`,
    `" . htmlspecialchars($registro['qtdberco']) . "`,
    `" . htmlspecialchars($registro['checkin']) . "`,
    `" . htmlspecialchars($registro['checkout']) . "`
)' class='btn btn-outline-primary'>
    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
        <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
        <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
    </svg> Alterar
</button>
                  
            &nbsp;
            <a href='devolvercamaapp.php?excluir_idcama=" . htmlspecialchars($registro['idcama']) . "' onclick='return confirm(\"Tem certeza que deseja DEVOLVER?\")'>
                <button type='button' class='btn btn-outline-primary'>
                    <svg xmlns=http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-reply-all' viewBox='0 0 16 16'>
                    <path d='M8.098 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.7 8.7 0 0 0-1.921-.306 7 7 0 0 0-.798.008h-.013l-.005.001h-.001L8.8 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L4.114 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028zM9.3 10.386q.102 0 .223.006c.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96z'/>
                    <path d='M5.232 4.293a.5.5 0 0 0-.7-.106L.54 7.127a1.147 1.147 0 0 0 0 1.946l3.994 2.94a.5.5 0 1 0 .593-.805L1.114 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028 4.012-2.954a.5.5 0 0 0 .106-.699'/>
                    </svg> Devolver
                </button>
            </a>

</div>
</center>";

break;


case 'Recepcao':
    $listaRegistros .= "<div class='d-inline p-2 text-bg-link'><strong>Cama Montada: </strong> ".
                ($registro['camamontada'] == '0' ? '<img src="imagens/esferavermok.png" width="15px">':'<img src="imagens/esferaverdeok.png" width="15px">')
                ."</div><br><br>";
      
    $listaRegistros .= " 
    
                <div class='col-md-5 col-12'>
                <div class='p-3 mb-3 bg-success text-white'>
        
        <div class='container text-center'>
          <div class='row'>
            <div class='col-3'>
                <img src='imagens/marcadortitulo1.png' width='35' alt='Seta'>
        </div>
        <div class='col-6'>
            <form class='row g-3 gy-2 align-items-center' action='vincularquartoapp.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name='idcama' value='" . htmlspecialchars($registro['idcama']) . "'>
        
                <select class='form-select form-select-sm' name='quarto' aria-label='Small select example'>
                    <option selected>". htmlspecialchars($registro['quarto']) ."</option>
                    ";
        
                $sql2 = "SELECT * FROM apartamentocamaextra ORDER BY idapartamento ASC";
                $stmt2 = $pdo->query($sql2);
                $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
                foreach($result2 as $row2){
                    $listaRegistros .= "<option value='". htmlspecialchars($row2['apartamento']) ."'>". htmlspecialchars($row2['apartamento']) ."</option>";
        
                }
        
                $listaRegistros .= "
                </select>
        </div>
        <div class='col-2'>
                <button type='submit' class='btn btn-link' onclick='return confirm(\"Vincular Quarto?\")'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='icon-svg' viewBox='0 0 16 16'>
                    <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                    <path d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z'/>
                    </svg>
                </button>
                        
                </form>
                </div>
              </div>
             
            ";
break;
default:
            echo "&nbsp; &nbsp; <center><img src='imagens/permissao321.png' width='120px'><br>Usuário sem Permissão!</center>";
            break;
    }

} else {
  echo "Usuário não encontrado!";
}

$listaRegistros .="
                     
</div>

</div></div></div>

";
}

}
// Chamar a função para exibir o calendário
criarCalendarioMensalPorSemana($pdo, $mes, $ano);
echo "<br>";
echo $listaRegistros;

?>

<!-- script complementa o onclick do botão de excluir! -->
<script>
    function confirmDeletion(id) {
        if (confirm('Devolver a(s) CAMA(s)?')) {
            window.location.href = 'devolvercamaextra.php?idcama=' + id;
        }
    }
</script>
<!-- Fim do script botão excluir -->

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



    <!-- Botão para abrir o pop-up -->
    <!-- <button onclick="openPopup()">Abrir Pop-up</button>-->

    <!-- Estrutura do pop-up -->
    <div id="popup">
        <div id="popup-content">
            <p>
         
  <form class="row gy-2" action="alterarcamaextra.php" method="post">
  <input type='hidden' name='idcama' value='<?php echo $registro['idcama'];?>'>
  <label for="reserva" style='font-size: 11px;'>Nº da Reserva</label>
  <input type="text" class="form-control" name="reserva" id="reserva" placeholder="Nº da Reserva" value="<?php $registro['reserva']?>" required>

  <select class="form-select" name="qtdcama" id="qtdcama" required>
    <option value="">Cama Extra</option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>

  </select>

  <select class="form-select" name="qtdberco" id="qtdberco" required>
    <option value="">Berço</option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>

  </select>



  <label for="checkin" style='font-size: 11px;'>Check-in</label>
  <input type="date" class="form-control" name="checkin" id="checkin" placeholder="Check-in" required>



  <label for="checkout" style='font-size: 11px;'>Check-out</label>
  <input type="date" class="form-control" name="checkout" id="checkout" placeholder="Check-out" required>

  <br>
  <input type="submit" value="Alterar" class="btn btn-outline-light" style="background-color: #088A08";>

</form>
<div class="row">
  <button class="close-btn" onclick="closePopup()">Fechar</button>
</div>
    </p>
           <!-- <button class="close-btn" onclick="closePopup()">Fechar</button> -->
    </div>
        </div>


    <!-- JavaScript para abrir e fechar o pop-up -->
    <script>
        function openPopup(reserva, qtdCama, qtdBerco, checkin, checkout) {

            // Preencha os campos do pop-up com os valores do registro
            document.getElementById("reserva").value = reserva;
            document.getElementById("qtdcama").value = qtdCama;
            document.getElementById("qtdberco").value = qtdBerco;
            document.getElementById("checkin").value = checkin;
            document.getElementById("checkout").value = checkout;
// Exiba o pop-up
            document.getElementById("popup").style.display = "flex";
        }

        function closePopup() {
// Esconde o pop-up
            document.getElementById("popup").style.display = "none";
        }
    </script>

</body>
</html>
