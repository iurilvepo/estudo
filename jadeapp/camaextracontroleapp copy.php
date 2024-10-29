<?php
session_start();

// Verifica se o usuário está logado. Se não, redireciona para a página de login.
if (!isset($_SESSION['idlogin'])) {
    header("location: index.php");
} else {
    $nivel = $_SESSION['nivel'];
}

// Inclui o arquivo de conexão com o banco de dados.
include('connect_app2.php');

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <!-- Custom styles -->
    <link href="style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Fim styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    </style>

<body>

<br><br><br>
    <label style="font-family: poppins;"><b><p><img src="imagens/camagov01.png" width="50"> &nbsp;&nbsp; Controle de Camas Extra</p></b></label>
<br>

<?php
$sql = "SELECT * FROM camaextraqtd";
$stmt = $pdo->query($sql);
$stmt -> execute();

$result = $stmt -> fetch(PDO::FETCH_ASSOC);

$cama1 = (42 - $result['total_cama']);
$berco1 = (4 - $result['total_berco']);
echo"
<div class='registro-card' style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin-bottom: 10px; background-color: #f9f9f9;'>
       
    <div class='registro-header' style='display: flex; align-items: center;'>
        <div style='flex-grow: 1; margin-left: 10px;'>
            <div style='font-size: 11px;'><img src='imagens/seta.png'><strong> Total de Camas:</strong>&nbsp;&nbsp;&nbsp;&nbsp; <strong style='font-size: 11px; color: #2F4F4F;'>42</strong></div>
            <div style='font-size: 11px;'><img src='imagens/seta.png'><strong> Cama disponivel:</strong> &nbsp;&nbsp;<strong style='font-size: 11px; color: #008000;'>" . htmlspecialchars($cama1) . "</strong></div>
            <div style='font-size: 11px;'><img src='imagens/seta.png'><strong> Cama em Uso: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style='font-size: 11px; color: #FF0000;'>" . htmlspecialchars($result['total_cama']) . "</strong></div>
        </div>
        
        <div style='flex-grow: 2; margin-left: 10px;'>
            <div style='font-size: 11px;'><img src='imagens/seta.png'><strong> Total de Berços: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<strong style='font-size: 11px; color: #2F4F4F;'>4</strong></div>
            <div style='font-size: 11px;'><img src='imagens/seta.png'><strong> Berço disponivel:</strong> &nbsp;&nbsp;<strong style='font-size: 11px; color: #008000;'>" . htmlspecialchars($berco1) . "</strong></div>
            <div style='font-size: 11px;'><img src='imagens/seta.png'><strong> Berço em Uso: </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style='font-size: 11px; color: #FF0000;'>" . htmlspecialchars($result['total_berco']) . "</strong></div>
        </div>
    </div>
</div>
";

echo "<a href ='camaextracontroleapp.php' style='font-size: 11px;'><center>Atualizar informações <img src='imagens/atualizar6.png' width='15px'></center></a> <br>";

// Função para criar o calendário e distribuir camas e berços
function criarCalendarioComReservas($ano, $mes, $pdo) {
    $diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
    $meses = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
    ];

    $primeiroDiaDoMes = mktime(0, 0, 0, $mes, 1, $ano);
    $numeroDeDias = date('t', $primeiroDiaDoMes);
    $componentesDaData = getdate($primeiroDiaDoMes);
    $nomeDoMes = $meses[(int)$mes];
    $diaDaSemana = $componentesDaData['wday'];

    // Iniciando a tabela de calendário
    #$calendario = "<h2>$nomeDoMes $ano</h2>";
?>
<br>
<!-- Formulário para seleção do mês e ano -->
<div class='registro-card' style='padding: 1px; margin-bottom: 5px;'>

    <form method="POST" action="">
        <div class='registro-header' style='display: flex; align-items: center;'>
            <img src="imagens/calen234.png" width="25px"> 
            <div style='flex-grow: 0; margin-left: 5px;'>
                <select name="mes" class="form-select form-select-sm">
                    <option value="1" <?= ($mes == 1) ? 'selected' : '' ?>>Janeiro</option>
                    <option value="2" <?= ($mes == 2) ? 'selected' : '' ?>>Fevereiro</option>
                    <option value="3" <?= ($mes == 3) ? 'selected' : '' ?>>Março</option>
                    <option value="4" <?= ($mes == 4) ? 'selected' : '' ?>>Abril</option>
                    <option value="5" <?= ($mes == 5) ? 'selected' : '' ?>>Maio</option>
                    <option value="6" <?= ($mes == 6) ? 'selected' : '' ?>>Junho</option>
                    <option value="7" <?= ($mes == 7) ? 'selected' : '' ?>>Julho</option>
                    <option value="8" <?= ($mes == 8) ? 'selected' : '' ?>>Agosto</option>
                    <option value="9" <?= ($mes == 9) ? 'selected' : '' ?>>Setembro</option>
                    <option value="10" <?= ($mes == 10) ? 'selected' : '' ?>>Outubro</option>
                    <option value="11" <?= ($mes == 11) ? 'selected' : '' ?>>Novembro</option>
                    <option value="12" <?= ($mes == 12) ? 'selected' : '' ?>>Dezembro</option>
                </select>
            </div>
            
            <div style='flex-grow: 0; margin-left: 5px;'>
                <select name="ano" class="form-select form-select-sm">
                    <?php
                    for ($i = date('Y') - 5; $i <= date('Y') + 5; $i++) {
                        $selected = ($ano == $i) ? 'selected' : '';
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div style='flex-grow: 1; margin-left: 2px;'>
                <button type="submit" class="btn btn-link"><img src="imagens/avanca123.png" width="30px"></button>
            </div>
        </div>
    </form>
</div>

<?php
    $calendario .= "<table>";
    $calendario .= "<tr style='font-size: 9px;'>";

    foreach ($diasDaSemana as $dia) {
        $calendario .= "<th style='font-size: 9px; padding: 5px;'>$dia</th>";
    }

    $calendario .= "</tr><tr>";

    if ($diaDaSemana > 0) {
        $calendario .= "<td colspan='$diaDaSemana' style='padding: 0px;'>&nbsp;</td>";
    }

    $diaAtual = 1;

#################
    while ($diaAtual <= $numeroDeDias) {
        if ($diaDaSemana == 7) {
            $diaDaSemana = 0;
            $calendario .= "</tr><tr>";
        }
    
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
    
        // Exibir os valores acumulados de camas e berços
        $textoReserva = '';
        if ($totalCamas > 0) {
            $textoReserva .= "<h7 style='font-family: poppins; font-size: 9px;'>Cama: $totalCamas</h7><br>";
        }
        if ($totalBercos > 0) {
            $textoReserva .= "<h7 style='font-family: poppins; font-size: 9px;'>Berço: $totalBercos</h7>";
        }
    
        $calendario .= "<td style='padding: 0px;'><h7 style='font-family: poppins; font-size: 9px; color: #008000;'>$diaAtual</h7><br>$textoReserva</td>";
    
        $diaAtual++;
        $diaDaSemana++;
    }
################    

    if ($diaDaSemana != 7) {
        $diasRestantes = 7 - $diaDaSemana;
        $calendario .= "<td style='padding: 0px;' colspan='$diasRestantes'>&nbsp;</td>";
    }

    $calendario .= "</tr>";
    $calendario .= "</table>";

    return $calendario;
}

// Função para atualizar a tabela camaextraqtd
function atualizarCamaBerco($pdo) {
    $stmt = $pdo->prepare("
        UPDATE camaextraqtd
        SET total_cama = (
            SELECT SUM(qtdcama) FROM camaextraapp
        ),
        total_berco = (
            SELECT SUM(qtdberco) FROM camaextraapp
        )
    ");
    $stmt->execute();
}

// Atualizando a tabela camaextraqtd
atualizarCamaBerco($pdo);

// Obtendo o mês e ano atual
#$ano = date('Y');
#$mes = date('m');

// Obtendo o mês e ano selecionado
$ano = isset($_POST['ano']) ? (int)$_POST['ano'] : date('Y');
$mes = isset($_POST['mes']) ? (int)$_POST['mes'] : date('m');

// Exibindo o calendário com as reservas
echo criarCalendarioComReservas($ano, $mes, $pdo);

?>


 <!-- FIM do Formulário para seleção do mês e ano -->

<?php

echo "<br>";

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

<br>
<div class='registro-header' style='display: flex; align-items: center;'>
            <div style='flex-grow: 0; margin-left: 10px;'>
                <img src='imagens/marcadortitulo.png' width='25' alt='Seta'>
                <strong>UH:</strong> 

            </div>
            <div style='flex-grow: 0; margin-left: 10px;'>

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

            <div style='flex-grow: 1; margin-left: 10px;'>
                <button type='submit' class='btn btn-link' onclick='return confirm(\"Vincular Quarto?\")'>
                    <img src='imagens/Valid.png' width='25'>
                </button>
                        
                </form>
                    
            </div>
            
                  
</div>
<br>
<center>
<div class='registro-actions' style='display: flex; align-items: center; justify-content: flex-end;'>
            
            <a href='devolvercamaapp.php?excluir_idcama=" . htmlspecialchars($registro['idcama']) . "' onclick='return confirm(\"Tem certeza que deseja DEVOLVER?\")'>
                <button type='button' class='btn btn-outline-primary'>
                    <img src='imagens/devolver123.png' width='25' alt='Devolução'> DEVOLUÇÃO
                </button>
            </a>

</div>
</center>


</div>

";
}

}

// Exibir o calendário e a lista de registros
echo $calendario; 
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
    <div class="row">
        <div class="col">
            <div class="card text-primary-emphasis mb-2 border border-black-subtle rounded-3 shadow">
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
