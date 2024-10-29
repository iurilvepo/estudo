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
