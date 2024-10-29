<?php

session_start();

if(!isset($_SESSION['idlogin']) ){
    header("location: index.php");
}else{ }

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
<title>Jade</title>
</head>

<body>
<br>
<br>
<br>
<br>
<a href="#" id="download"><img src="imagens/downpdf.webp" width="20"></a>
<div id="content">
<h6><b><p><center>Manutenção de Ar-Condicionado - Por DATA!</center></p></b></h6>
<table class='table'>
<thead>
<tr class='table-warning'>
<th scope='col' style='font-size: 10px;'>Apartamento</th>
<th scope='col' style='font-size: 10px;'>Data da O.S.</th>
<th scope='col' style='font-size: 10px;'>Prioridade</th>
<th scope='col' style='font-size: 10px;'>Serviço</th>
<th scope='col' style='font-size: 10px;'>Prestador</th>
</tr>
</thead>
<tbody>

<?php
include_once("connect_app2.php");

$sql = "SELECT * FROM arcondicionadoapp ORDER BY `data` DESC";

$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){

    echo"
      <tr class='table-group-divider'>
      <td style='font-size: 10px;'><img src='imagens/setahome123.png' width='20'> ".$row['apartamento']."</td>
      <td style='font-size: 10px;'>".$row['data']."</td>
      <td style='font-size: 10px;'>".$row['tipostatus']."</td>
      <td style='font-size: 10px;'>".$row['servico']."</td>
      <td style='font-size: 10px;'>".$row['pessoatec']."</td>
      </tr>
      <tr>
      <td colspan='1' style='font-size: 10px;'><img src='imagens/obs123.png' width='20'> - <strong>Observação da O.S. :</strong></td>
      <td colspan='4' style='font-size: 10px;'>".$row['observacao']."</td>
      </tr>
      <tr>
      <td colspan='1' style='font-size: 10px;'><img src='imagens/obs123.png' width='20'> - <strong>Observação Técnica :</strong></td>
      <td colspan='4' style='font-size: 10px;'>".$row['observacaotec']."</td>
      </tr>";
}
?>


</tbody>
</table>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
</div>

<!-- scritp gerar PDF -->
<script>
        document.getElementById('download').addEventListener('click', function () {
            var element = document.getElementById('content');

            var opt = {
                margin: 1,
                filename: 'relatorio_data.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().from(element).set(opt).outputPdf('blob').then(function (pdfBlob) {
                var url = URL.createObjectURL(pdfBlob);
                var link = document.createElement('a');
                link.href = url;
                link.download = 'relatorio_data.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            });
        });
    </script>
</body>
</html>
