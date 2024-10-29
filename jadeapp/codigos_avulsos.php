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
















<?php
// Inclui o arquivo de conexão com o banco de dados.
include('connect_app2.php');

function criarCalendarioComReservas($pdo, $diasAdicionados) {
    $diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

    // Array com os nomes dos meses abreviados em português
    $mesesAbreviados = [
        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 
        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 
        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
    ];

    // Obter o dia atual
    $diaAtual = date('j'); // Dia atual
    $mesAtual = date('n'); // Mês atual
    $anoAtual = date('Y'); // Ano atual

    echo "<h2>Calendário Corrido a partir de Hoje</h2>";

    // Exibe 30 dias corridos
    for ($semana = 0; $semana < 4; $semana++) {
    echo"<div class='registro-card' style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin-bottom: 10px; background-color: #f9f9f9;'>

        <div class='registro-header' style='display: flex; align-items: center;'>
        ";

        echo "<table>";
        echo "<tr><th style='padding: 0px;'>$anoAtual</th>"; // Coluna vazia na esquerda
        foreach ($diasDaSemana as $dia) {
            echo "<th style='padding: 0px;'>$dia</th>"; // Primeira linha com os dias da semana
        }
        echo "</tr>";
        echo "<tr><td style='padding: 0px;'><strong>Dias</strong></td>"; // Coluna extra vazia

        // Exibe 7 dias por semana, começando do dia atual
        for ($i = 0; $i < 7; $i++) {
            $data = mktime(0, 0, 0, $mesAtual, $diaAtual + $diasAdicionados, $anoAtual);
            $diaMes = date('j', $data);
            $mesNumero = date('n', $data); // Obtém o número do mês
            $mesNomeAbreviado = $mesesAbreviados[$mesNumero]; // Obtém o nome abreviado do mês em português

            echo "<td style='padding: 0px;'><strong>$diaMes</strong>&nbsp;$mesNomeAbreviado</td>";
            $diasAdicionados++;
        }
        echo "</tr>";

        // Segunda linha com o número de camas
        echo "<tr><td style='padding: 0px; text-align: left;'><strong>Cama: 42</strong></td>"; // Coluna extra vazia
        for ($i = 0; $i < 7; $i++) {
            echo "<td style='padding: 0px;'>42</td>"; // Exibe o número 42
        }

        echo "</tr>";
        echo "<tr><td style='padding: 0px; text-align: left;'><strong>Berço: 4</strong></td>"; // Coluna extra vazia
        for ($i = 0; $i < 7; $i++) {
            echo "<td style='padding: 0px;'>4</td>"; // Exibe o número 4
        }
        echo "</tr>";
        echo "</table><br>"; // Quebra de linha entre as tabelas

        echo"</div></div>";
    }
}

// Recebe o número de dias adicionados
$diasAdicionados = isset($_POST['diasAdicionados']) ? (int)$_POST['diasAdicionados'] : 0;

// Exibe o calendário
criarCalendarioComReservas($pdo, $diasAdicionados);
?>






















<?php
// Inclui o arquivo de conexão com o banco de dados.
include('connect_app2.php');

function criarCalendarioMensalPorSemana($pdo) {
    $diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];

    // Array com os nomes dos meses abreviados em português
    $mesesAbreviados = [
        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 
        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 
        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
    ];

    // Obter o mês e ano atual
    $mesAtual = date('n');
    $anoAtual = date('Y');

    // Obter o primeiro e o último dia do mês
    $primeiroDiaDoMes = mktime(0, 0, 0, $mesAtual, 1, $anoAtual);
    $ultimoDiaDoMes = mktime(0, 0, 0, $mesAtual + 1, 0, $anoAtual); // Último dia do mês

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
        echo "<th style='padding: 0px;'>$anoAtual</th>"; // Coluna extra à esquerda

        // Cabeçalho com os dias da semana
        foreach ($diasDaSemana as $dia) {
            echo "<th style='padding: 0px;'>$dia</th>";
        }

        echo "</tr><tr>";

        // Exibir a coluna extra e cada dia da semana
        for ($i = 0; $i < 7; $i++) {
            if ($i == 0) {
                echo "<td style='padding: 0px;'><strong>Dias</strong></td>"; // Coluna extra
            }

            if ($diaAtual <= 0) {
                // Exibir dias do mês anterior
                $mesAnterior = $mesAtual - 1;
                $anoAnterior = $anoAtual;
                if ($mesAnterior == 0) {
                    $mesAnterior = 12;
                    $anoAnterior--;
                }
                $diaMesAnterior = date('j', mktime(0, 0, 0, $mesAnterior, $diaAtual, $anoAnterior));
                $mesNomeAbreviado = $mesesAbreviados[$mesAnterior];
                echo "<td style='padding: 0px; text-align: center; color: #999;'>$diaMesAnterior&nbsp;$mesNomeAbreviado</td>";
            } elseif ($diaAtual > $diasNoMes) {
                // Exibir dias do próximo mês
                $mesProximo = $mesAtual + 1;
                $anoProximo = $anoAtual;
                if ($mesProximo > 12) {
                    $mesProximo = 1;
                    $anoProximo++;
                }
                $diaMesProximo = date('j', mktime(0, 0, 0, $mesProximo, $diaAtual - $diasNoMes, $anoProximo));
                $mesNomeAbreviado = $mesesAbreviados[$mesProximo];
                echo "<td style='padding: 0px; text-align: center; color: #999;'>$diaMesProximo&nbsp;$mesNomeAbreviado</td>";
            } else {
                // Exibir dias do mês atual
                $dataAtual = mktime(0, 0, 0, $mesAtual, $diaAtual, $anoAtual);
                $diaMes = date('j', $dataAtual);
                $mesNomeAbreviado = $mesesAbreviados[$mesAtual];
                echo "<td style='padding: 0px; text-align: center;'><strong>$diaMes</strong>&nbsp;$mesNomeAbreviado</td>";
            }

            $diaAtual++;
        }

        echo "</tr>";

        // Segunda linha com o número de camas (exemplo)
        echo "<tr>";
        echo "<td style='padding: 0px; text-align: left;'><strong>Cama: 42</strong></td>"; // Coluna extra
        for ($i = 0; $i < 7; $i++) {
            echo "<td style='padding: 0px; text-align: center;'>42</td>"; // Exibe o número 42 como exemplo
        }
        echo "</tr>";

        // Terceira linha com o número de berços (exemplo)
        echo "<tr>";
        echo "<td style='padding: 0px; text-align: left;'><strong>Berço: 4</strong></td>"; // Coluna extra
        for ($i = 0; $i < 7; $i++) {
            echo "<td style='padding: 0px; text-align: center;'>4</td>"; // Exibe o número 4 como exemplo
        }
        echo "</tr>";

        echo "</table>";
        echo "</div>";

        // Se o último dia da semana for sábado, iniciar uma nova tabela
        if ($diaAtual > $diasNoMes && $i < 6) {
            break;
        }
    }
}

// Exibe o calendário
criarCalendarioMensalPorSemana($pdo);
?>












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
                <button type="submit" class="btn btn-link"><img src="imagens/avanca123.png" width="30px"></button>
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
                echo "<td style='padding: 0px;'><strong>Dias</strong></td>"; // Coluna extra
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
                echo "<td style='padding: 0px; text-align: center; color: #999;'>$diaMesAnterior&nbsp;$mesNomeAbreviado</td>";
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
                echo "<td style='padding: 0px; text-align: center; color: #999;'>$diaMesProximo&nbsp;$mesNomeAbreviado</td>";
            } else {
                // Exibir dias do mês atual
                $dataAtual = mktime(0, 0, 0, $mes, $diaAtual, $ano);
                $diaMes = date('j', $dataAtual);
                echo "<td style='padding: 0px; text-align: center;'>$diaMes</td>";
            }

            $diaAtual++;
        }

        echo "</tr>";
        echo "</table>";
        echo "</div>";

        $diaDaSemanaPrimeiroDia = 0; // Reiniciar o primeiro dia da semana para os próximos ciclos
    }
}

// Chamar a função para exibir o calendário
criarCalendarioMensalPorSemana($pdo, $mes, $ano);

?>

</body>
</html>
