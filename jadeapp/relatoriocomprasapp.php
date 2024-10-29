<?php
session_start();
if (!isset($_SESSION['idlogin'])) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'></script>
    <link href='style.css' rel='stylesheet' type='text/css' media='all' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    <title>Jade - Relatório de Compras</title>
</head>
<body>
<br><br><br><br>

<!-- Formulário de busca -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-0">
            <div class="col">
                    <form method="GET" action="">
                            <label for="status">Buscar por Status:</label>
                            <select name="status" id="status" class="form-select" aria-label="Default select example">
                                <option value="">Todos</option>
                                <option value="Aguardando...">Aguardando...</option>
                                <option value="COTACAO">Cotação</option>
                                <option value="COMPRA REALIZADA">Compra Realizada</option>
                                <option value="MATERIAL RECEBIDO">Material Recebido</option>
                                <option value="ENTREGUE AO SETOR">Entregue ao Setor</option>
                                <option value="PROCESSO FINALIZADO">Processo Finalizado</option>
                            </select>
                
            </div>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-0">
    <div class="col">
        <button type="submit" class="btn btn-primary mt-2">Buscar</button>
    </div>
</div>       

</form>

<div id="content">

<div class="row row-cols-3 row-cols-sm-3 row-cols-md-3 g-0">
    <div class="col">
    </div>
    <div class="col">
        <h6><b><p><center>Relatório de Compras!</center></p></b></h6>
    </div>
    <div class="col">
        <center><a href="#" id="download"><img src="imagens/downpdf.webp" width="20"></a></center>
    </div>
</div>

    <table class='table'>

<?php
include_once("connect_app2.php");

// Pega o valor do status selecionado pelo usuário
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Cria a consulta SQL com base no filtro de status
$sql = "SELECT * FROM comprasapp";
if ($status && $status != 'Todos') {
    $sql .= " WHERE status = :status";
}
$sql .= " ORDER BY `idcompras` DESC";

$stmt = $pdo->prepare($sql);
if ($status && $status != 'Todos') {
    $stmt->bindParam(':status', $status);
}
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    
    $pg = $row['em_pagamento'] == 1 ? "Sim" : "Não";
    $bol = $row['boleto'] == 1 ? "Sim" : "Não";
    $nf = $row['nf'] == 1 ? "Sim" : "Não";
    $dt = $row['data_recebimento'] == '0000-00-00' ? 'Não informado!' : date('d/m/Y', strtotime($row['datapedido']));

    echo "
    <thead>
    <tr class='table-warning'>
        <th scope='col' style='font-size: 11px;'><img src='imagens/setahome123.png' width='15'> Nº Pedido: " . $row['idcompras'] . "</th>
        <th scope='col' style='font-size: 11px;'>Quantidade: " . $row['quantidade'] . "</th>
        <th colspan='2' scope='col' style='font-size: 11px;'>Destino: " . $row['setor_destino'] . "</th>
    </tr>
    </thead>
    <tbody>
        <tr class='table-group-divider'>
            <td colspan='4' style='font-size: 11px;'><strong>Material:</strong> " . $row['material'] . "</td>
        </tr>
        <tr>
            <td style='font-size: 11px;'><strong>Data:</strong> " . date('d/m/Y', strtotime($row['datapedido'])) . "</td>
            <td style='font-size: 11px;'><strong>Solicitante:</strong> " . $row['solicitante'] . "</td>
            <td style='font-size: 11px;'><strong>Empresa:</strong> " . $row['empresa'] . "</td>
            <td style='font-size: 11px;'><strong>Status:</strong> " . $row['status'] . "</td>
        </tr>
        <tr>
            <td style='font-size: 11px;'><strong>Data Recebimento:</strong> " . $dt . "</td>
            <td style='font-size: 11px;'><strong>NF:</strong> " . $nf . " <strong>Boleto:</strong> " . $bol . "</td>
            <td style='font-size: 11px;'><strong>Enviado p/ Pagamento:</strong> " . $pg . "</td>
            <td style='font-size: 11px;'><a href='" . $row['link'] . "' target='_blank'>Link!</a></td>
        </tr>
    ";
}
?>

</tbody>
</table>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
</div>

<!-- script gerar PDF -->
<script>
document.getElementById('download').addEventListener('click', function () {
    var element = document.getElementById('content');
    var opt = {
        margin: 1,
        filename: 'relatorio_compras.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().from(element).set(opt).outputPdf('blob').then(function (pdfBlob) {
        var url = URL.createObjectURL(pdfBlob);
        var link = document.createElement('a');
        link.href = url;
        link.download = 'relatorio_compras.pdf';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    });
});
</script>
</body>
</html>
