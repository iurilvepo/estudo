<!DOCTYPE html>
<html>

<head>
    <title>Jade</title>
</head>

<body>

<?php
// Parâmetros de conexão com o banco de dados Oracle
$host = "10.61.6.100"; // Endereço IP do servidor Oracle
$sid = "xe";      // Substitua pelo SID do banco de dados
$user = "cm";          // Nome de usuário do banco de dados
$password = "oracle11g"; // Senha do banco de dados

// String de conexão
$connection = oci_connect($user, $password, "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=1521)))(CONNECT_DATA=(SID=$sid)))");

// Verifica se a conexão foi bem-sucedida
if (!$connection) {
    $error = oci_error();
    die("Erro de conexão: " . $error['message']);
} else {
  echo "Conexão bem-sucedida!";
}

$sql = "SELECT

NUMRESERVA,
IDHOSPEDE,
STATUSRESERVA,
CODREDUZIDO,
NOMEHOSPEDE,
TIPOHOSPEDE,
RAZAOSOCIAL,
CLIENTE,
TARIFA,
NOMEHOSPEDECOMPLETO,
DATACHEGPREVISTA,
VLRDIARIA,
OBSERVACOES

FROM (

SELECT  CASE WHEN R.STATUSRESERVA IN  (0,1,7,8, 5, 6) THEN (SELECT VALOR FROM ORCAMENTORESERVA O1 WHERE O1.IDRESERVASFRONT = R.IDRESERVASFRONT                                                         AND DATA = (SELECT MIN(DATA) FROM ORCAMENTORESERVA OREO1                                                                                             WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))                        WHEN R.STATUSRESERVA IN (3,4) THEN (SELECT VALOR FROM ORCAMENTORESERVA O1 WHERE O1.IDRESERVASFRONT = R.IDRESERVASFRONT                                                         AND DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1                                                                                             WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))                                   WHEN R.STATUSRESERVA = 2 AND R.DATAPARTPREVISTA > PH.DATASISTEMA THEN (SELECT VALOR FROM ORCAMENTORESERVA O1                                                                                                    WHERE O1.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                                              AND DATA = PH.DATASISTEMA)                                    ELSE (SELECT VALOR FROM ORCAMENTORESERVA O1 WHERE O1.IDRESERVASFRONT = R.IDRESERVASFRONT                                                         AND DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1 WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))                END AS VLRDIARIA, TAR.FLGCONFIDENCIAL ,
        CASE WHEN RG.OBSERVACOES IS NULL THEN R.OBSERVACOES ELSE CASE WHEN R.OBSERVACOES IS NULL THEN RG.OBSERVACOES ELSE 'Reserva Grupo: '|| (NVL(RG.OBSERVACOES,' '))||' - Reserva Individual: '||(NVL(R.OBSERVACOES,' ')) END END AS OBSERVACOES,
        U.BLOCO, DECODE(NVL(AGENDA.QTDAGENDA,0),0,'N','S') AS FLGAGENDA, DECODE(NVL(MENSAGEM.QTDMENSAGEM,0),0,'N','S') AS FLGMENSAGEM,        
        H.IDHOSPEDE, TO_NUMBER(R.NUMRESERVAGDS) AS NUMRESERVAGDS, TO_NUMBER(R.NUMRESERVA) AS NUMRESERVA,R.STATUSRESERVA,R.IDRESERVASFRONT,M.DATACHEGREAL AS DTCHEGHOSPEDE, H.OBSERVACAO AS OBSHOSPEDE,  R.OBSSENSIVEIS,  
        M.DATAPARTREAL AS DTSAIDAHOSPEDE, STAT.DESCRICAO AS DESCSTATUS, R.DATACHEGADAREAL, R.DATACHEGPREVISTA,R.DATAPARTIDAREAL, R.DATAPARTPREVISTA, NVL(R.OBSERVACOES,' ') AS OBSRESERVA,  
        TO_DATE(TO_CHAR(DECODE(R.STATUSRESERVA,0 ,                                                                                          
                (NVL(R.HORACHEGADAREAL, R.HORACHEGPREVISTA)),1,                                                                            
        (NVL(R.HORACHEGADAREAL, R.HORACHEGPREVISTA)),                                                                                  
        (NVL(M.HORACHEGREAL, M.HORACHEGPREVISTA)) ),'DD/MM/YYYY HH24:MI:SS'),'DD/MM/YYYY HH24:MI:SS')  AS HORACHEGADA ,            
         TO_DATE(TO_CHAR(DECODE(R.STATUSRESERVA,0 ,                                                                                          
                (NVL(R.HORAPARTIDAREAL, R.HORAPARTPREVISTA)) ,1,                                                                          
        (NVL(R.HORAPARTIDAREAL, R.HORAPARTPREVISTA)) ,                                                                                
        (NVL(M.HORAPARTREAL,M.HORAPARTPREVISTA)) ),'DD/MM/YYYY HH24:MI:SS'),'DD/MM/YYYY HH24:MI:SS')AS HORAPARTIDA,                
        NVL(M.DATAPARTREAL, M.DATAPARTPREVISTA) AS DATAPARTIDA, R.GARANTENOSHOW,                                                            
        NVL(M.DATACHEGREAL, M.DATACHEGPREVISTA) AS DATACHEGADA,                                                                              
        R.CODUH, R.LOCRESERVA, R.CODREFERENCIA, T.CODREDUZIDO||' / '|| TRUH.CODREDUZIDO as CODREDUZIDO ,RG.OBSERVACOES AS OBSGRP,R.IDHOTEL, HT.NOME AS NOMEHOTEL,
              NVL(H.CODTRATAMENTO, '')||' '||H.SOBRENOME||';'||H.NOME|| DECODE(M.INCOGNITO,'N','',' (INC.)')         AS NOMEHOSPEDE,
        H.SOBRENOME||H.NOME AS NOMEHOSPEDEORD, RG.NOMEGRUPO,
        -- M.DATACHEGPREVISTA,        
        M.DATAPARTPREVISTA,                                                            
        R.ADULTOS  ,  
        R.CRIANCAS1,  
        R.CRIANCAS2,  
        R.DATADEPOSITO,R.DATACONFIRMACAO,R.DATARESERVA,TH.HOSPEDEVIP,TH.DESCRICAO AS TIPOHOSPEDE, R.DATACANCELAMENTO,        
        CASE WHEN R.STATUSRESERVA IN  (0,1,7,8, 5, 6) THEN (SELECT SEG.DESCRICAO  FROM SEGMENTO SEG, ORCAMENTORESERVA OREO          
                                                             WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                        
                                                               AND SEG.IDHOTEL = R.IDHOTEL                                          
                                                               AND SEG.CODSEGMENTO = OREO.CODSEGMENTO                              
                                                               AND OREO.DATA = (SELECT MIN(DATA) FROM ORCAMENTORESERVA OREO1        
                                                                                 WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))  
           WHEN R.STATUSRESERVA IN (3,4) THEN  (SELECT SEG.DESCRICAO  FROM SEGMENTO SEG, ORCAMENTORESERVA OREO                      
                                                 WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                    
                                                   AND SEG.IDHOTEL = R.IDHOTEL                                                      
                                                   AND SEG.CODSEGMENTO = OREO.CODSEGMENTO                                          
                                                   AND OREO.DATA = (SELECT MAX(DATA)  FROM ORCAMENTORESERVA OREO1                  
                                                                     WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))              
           WHEN R.STATUSRESERVA = 2 AND R.DATAPARTPREVISTA > PH.DATASISTEMA THEN (SELECT SEG.DESCRICAO                              
                                                                                    FROM SEGMENTO SEG, ORCAMENTORESERVA OREO        
                                                                                   WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT  
                                                                                     AND SEG.IDHOTEL = R.IDHOTEL                    
                                                                                     AND SEG.CODSEGMENTO = OREO.CODSEGMENTO        
                                                                                     AND OREO.DATA = PH.DATASISTEMA)                
           ELSE (SELECT SEG.DESCRICAO  FROM SEGMENTO SEG, ORCAMENTORESERVA OREO                                                    
                  WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                                                  
                    AND SEG.IDHOTEL = R.IDHOTEL                                                                                    
                    AND SEG.CODSEGMENTO = OREO.CODSEGMENTO                                                                          
                    AND OREO.DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1 WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))
      END AS SEGMENTO,                                                                                                              
                                                                                                                                   
      CASE WHEN R.STATUSRESERVA IN  (0,1,7,8, 5, 6) THEN (SELECT ORG.DESCRICAO  FROM ORIGEMRESERVA ORG, ORCAMENTORESERVA OREO      
                                                           WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                          
                                                             AND ORG.IDORIGEM = OREO.IDORIGEM                                      
                                                             AND OREO.DATA = (SELECT MIN(DATA) FROM ORCAMENTORESERVA OREO1          
                                                                               WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))    
           WHEN R.STATUSRESERVA IN (3,4) THEN  (SELECT ORG.DESCRICAO  FROM ORIGEMRESERVA ORG, ORCAMENTORESERVA OREO                
                                                 WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                    
                                                   AND ORG.IDORIGEM = OREO.IDORIGEM                                                
                                                   AND OREO.DATA = (SELECT MAX(DATA)  FROM ORCAMENTORESERVA OREO1                  
                                                                     WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))              
           WHEN R.STATUSRESERVA = 2 AND R.DATAPARTPREVISTA > PH.DATASISTEMA THEN (SELECT ORG.DESCRICAO                              
                                                                                    FROM ORIGEMRESERVA ORG, ORCAMENTORESERVA OREO  
                                                                                   WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT  
                                                                                     AND ORG.IDORIGEM = OREO.IDORIGEM              
                                                                                     AND OREO.DATA = PH.DATASISTEMA)                
           ELSE (SELECT ORG.DESCRICAO  FROM ORIGEMRESERVA ORG, ORCAMENTORESERVA OREO                                                
                  WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                                                  
                    AND ORG.IDORIGEM = OREO.IDORIGEM                                                                                
                    AND OREO.DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1 WHERE OREO1.IDRESERVASFRONT = R.IDRESERVASFRONT))
      END AS ORIGEM,                                                                                                                
        TO_CHAR(R.ADULTOS)||'/'||TO_CHAR(R.CRIANCAS1)||'/'||TO_CHAR(R.CRIANCAS2) AS NHOSPEDES,      
        CLI.RAZAOSOCIAL,CLI.NOME AS CLIENTE,PO.NOME AS POSTO,                                                                                
        CONT.CODCONTRATO, M.INCOGNITO, M.SENHATELEFONIA, U.DESCRICAO AS DESCRICAOUH, R.OBSCMNET,        
        CASE WHEN (SELECT PCH.DESCRICAO                                                                                                      
                     FROM PACOTEHOTEL PCH, ORCAMENTORESERVA OREO                                                                            
                    WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                          
                      AND PCH.IDPACOTE         = OREO.IDPACOTE                                                                              
                      AND PCH.IDHOTEL          = OREO.IDHOTEL                                                                                
                      AND PH.IDHOTEL           = OREO.IDHOTEL                                                                                
                      AND OREO.DATA            = PH.DATASISTEMA) IS NOT NULL                                                                
             THEN (SELECT PCH.DESCRICAO                                                                                                      
                     FROM PACOTEHOTEL PCH, ORCAMENTORESERVA OREO                                                                            
                    WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                          
                      AND PCH.IDPACOTE         = OREO.IDPACOTE                                                                              
                      AND PCH.IDHOTEL          = OREO.IDHOTEL                                                                                
                      AND PH.IDHOTEL           = OREO.IDHOTEL                                                                                
                      AND OREO.DATA            = PH.DATASISTEMA)                                                                            
             ELSE CASE WHEN  (R.DATACHEGPREVISTA > PH.DATASISTEMA AND                                                                        
                        (SELECT PCH.DESCRICAO                                                                                                
                     FROM PACOTEHOTEL PCH, ORCAMENTORESERVA OREO                                                                            
                    WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                          
                      AND PCH.IDPACOTE         = OREO.IDPACOTE                                                                              
                      AND PCH.IDHOTEL          = OREO.IDHOTEL                                                                                
                      AND PH.IDHOTEL           = OREO.IDHOTEL                                                                                
                      AND OREO.DATA = R.DATACHEGPREVISTA)   IS NOT NULL    )                                                                
             THEN                                                                                                                            
                        (SELECT PCH.DESCRICAO                                                                                                
                     FROM PACOTEHOTEL PCH, ORCAMENTORESERVA OREO                                                                            
                    WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                          
                      AND PCH.IDPACOTE         = OREO.IDPACOTE                                                                              
                      AND PCH.IDHOTEL          = OREO.IDHOTEL                                                                                
                      AND PH.IDHOTEL           = OREO.IDHOTEL                                                                                
                      AND OREO.DATA = R.DATACHEGPREVISTA)                                                                                    
                  ELSE CASE WHEN  R.STATUSRESERVA = 3  AND                                                                                  
                             (SELECT PCH.DESCRICAO                                                                                          
                                FROM PACOTEHOTEL PCH, ORCAMENTORESERVA OREO                                                                  
                               WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                
                                 AND PCH.IDPACOTE         = OREO.IDPACOTE                                                                    
                                 AND PCH.IDHOTEL          = OREO.IDHOTEL                                                                    
                                 AND PH.IDHOTEL           = OREO.IDHOTEL                                                                    
                                 AND    OREO.DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1                                            
                                                        WHERE OREO1.IDRESERVASFRONT = OREO.IDRESERVASFRONT ))   IS NOT NULL                  
                            THEN (SELECT PCH.DESCRICAO                                                                                      
                                  FROM PACOTEHOTEL PCH, ORCAMENTORESERVA OREO                                                                
                                  WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                            
                                    AND PCH.IDPACOTE         = OREO.IDPACOTE                                                                
                                    AND PCH.IDHOTEL          = OREO.IDHOTEL                                                                  
                                    AND PH.IDHOTEL           = OREO.IDHOTEL                                                                  
                                    AND    OREO.DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1                                        
                                                        WHERE OREO1.IDRESERVASFRONT = OREO.IDRESERVASFRONT ))                                
                            ELSE  PAC.DESCRICAO                                                                                              
                  END END END AS PACOTE,                                                                                                    
        CASE WHEN (SELECT THO.DESCRICAO  FROM TARIFAHOTEL THO, ORCAMENTORESERVA OREO                                                          
                    WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                                                          
                      AND THO.IDTARIFA = OREO.IDTARIFA                                                                                      
                      AND THO.IDHOTEL = OREO.IDHOTEL                                                                                        
                      AND PH.IDHOTEL = OREO.IDHOTEL                                                                                          
                      AND OREO.DATA = PH.DATASISTEMA) IS NOT NULL                                                                            
             THEN (SELECT THO.DESCRICAO  FROM TARIFAHOTEL THO, ORCAMENTORESERVA OREO                                                        
                    WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                                                          
                      AND THO.IDTARIFA = OREO.IDTARIFA                                                                                      
                      AND THO.IDHOTEL = OREO.IDHOTEL                                                                                        
                      AND PH.IDHOTEL = OREO.IDHOTEL                                                                                          
                      AND OREO.DATA = PH.DATASISTEMA)                                                                                        
             ELSE CASE WHEN  (R.DATACHEGPREVISTA > PH.DATASISTEMA AND                                                                              
                        (SELECT THO.DESCRICAO FROM TARIFAHOTEL THO, ORCAMENTORESERVA OREO                                                    
                    WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                          
                      AND THO.IDTARIFA = OREO.IDTARIFA                                                                                      
                      AND THO.IDHOTEL = OREO.IDHOTEL                                                                                        
                      AND PH.IDHOTEL = OREO.IDHOTEL                                                                                          
                      AND OREO.DATA = R.DATACHEGPREVISTA)   IS NOT NULL    )                                                                
             THEN                                                                                                                            
                        (SELECT THO.DESCRICAO  FROM TARIFAHOTEL THO, ORCAMENTORESERVA OREO                                                  
                    WHERE OREO.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                          
                      AND THO.IDTARIFA = OREO.IDTARIFA                                                                                      
                      AND THO.IDHOTEL = OREO.IDHOTEL                                                                                        
                      AND PH.IDHOTEL = OREO.IDHOTEL                                                                                          
                      AND OREO.DATA = R.DATACHEGPREVISTA)                                                                                    
                  ELSE CASE WHEN  R.STATUSRESERVA = 3  AND                                                                                  
                             (SELECT THO.DESCRICAO FROM TARIFAHOTEL THO, ORCAMENTORESERVA OREO                                              
                                  WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                                            
                                    AND THO.IDTARIFA = OREO.IDTARIFA                                                                        
                                    AND THO.IDHOTEL = OREO.IDHOTEL                                                                          
                                    AND PH.IDHOTEL = OREO.IDHOTEL                                                                            
                                    AND    OREO.DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1                                        
                                                        WHERE OREO1.IDRESERVASFRONT = OREO.IDRESERVASFRONT ))   IS NOT NULL                  
                            THEN (SELECT THO.DESCRICAO FROM TARIFAHOTEL THO, ORCAMENTORESERVA OREO                                          
                                  WHERE OREO.IDRESERVASFRONT =  R.IDRESERVASFRONT                                                            
                                    AND THO.IDTARIFA = OREO.IDTARIFA                                                                        
                                    AND THO.IDHOTEL = OREO.IDHOTEL                                                                          
                                    AND PH.IDHOTEL = OREO.IDHOTEL                                                                            
                                    AND    OREO.DATA = (SELECT MAX(DATA) FROM ORCAMENTORESERVA OREO1                                        
                                                        WHERE OREO1.IDRESERVASFRONT = OREO.IDRESERVASFRONT ))                                
                            ELSE TAR.DESCRICAO                                                                                              
                  END END END AS TARIFA,                                                                                                    
      (SELECT TO_NUMBER(COUNT(*)) FROM CONTASFRONT WHERE (IDRESERVASFRONT = R.IDRESERVASFRONT) AND (IDHOSPEDE = M.IDHOSPEDE) AND DATAENCREAL IS NULL) AS NAOENCERRADAS
 ,H.NOMESOCIAL, LPAD(' ',20,' ') AS STATUSDARESERVA                                                                                      
 ,FX.TIPOETARIO, H.NOME || ' ' || H.SOBRENOME AS NOMEHOSPEDECOMPLETO                                                                                
 FROM   STATUSRESERVA STAT, UH U, TARIFAHOTEL TAR, PACOTEHOTEL PAC,TIPOUH T,TIPOUH TRUH,TIPOHOSPEDE TH, PARAMHOTEL PH, CONTRCLIHOTEL CONT,  
        RESERVAGRUPO RG, ROOMLISTVHF RL,PESSOA PHOSP, PESSOA CLI, PESSOA HT, PESSOA PO, HOSPEDE H,RESERVASFRONT R,MOVIMENTOHOSPEDES M, FAIXAETARIA FX,
        (SELECT IDRESERVASFRONT, SUM(1) AS QTDAGENDA                                                                                        
         FROM   MENSAGEMCM                                                                                                                  
         WHERE  LIDA = 0                                                                                                                    
         AND    NOMEREMETENTE IS NULL                                                                                                        
         AND    IDRESERVASFRONT IS NOT NULL                                                                                                  
         GROUP BY IDRESERVASFRONT) AGENDA,                                                                                                  
        (SELECT IDRESERVASFRONT, IDDESTINATARIO, SUM(1) AS QTDMENSAGEM FROM MENSAGEMCM                                                      
         WHERE IDRESERVASFRONT IS NOT NULL                                                                                                  
         AND   IDDESTINATARIO  IS NOT NULL                                                                                                  
         AND   LIDA         = 0                                                                                                            
         AND   NOMEREMETENTE IS NOT NULL                                                                                                    
         GROUP BY IDRESERVASFRONT, IDDESTINATARIO) MENSAGEM                                                                                  
 WHERE
 (R.IDHOTEL = 2)
 --STATUS 1 = CONFIRMADA / STATUS 2 = CHECKIN
 and (R.STATUSRESERVA IN (1,2) )
 and (M.DATACHEGREAL IS NULL and M.DATAPARTREAL IS NULL)
           AND (330091 NOT IN (SELECT GU.IDUSUARIO FROM GRUPOUSU GU, GRPUSUACESSORES GR
                         WHERE GR.IDHOTEL = R.IDHOTEL AND GU.IDGRUPO = GR.IDGRUPO) OR
               (330091 IN (SELECT GU.IDUSUARIO FROM GRUPOUSU GU, GRUPOUSU GURES
                WHERE GURES.IDUSUARIO = R.USUARIO
                AND   GU.IDGRUPO = GURES.IDGRUPO))) AND
     TH.IDTIPOHOSPEDE  = M.IDTIPOHOSPEDE                                                                                                  
 AND    PHOSP.IDPESSOA    = H.IDHOSPEDE
 AND    R.IDHOTEL         = HT.IDPESSOA                                                                                                      
 AND    R.IDHOTEL         = T.IDHOTEL                                                                                                        
 AND    R.IDHOTEL         = TRUH.IDHOTEL                                                                                                    
 AND    R.IDHOTEL         = TH.IDHOTEL    AND    R.IDHOTEL         = PH.IDHOTEL                                                              
 and r.idtarifa = tar.idtarifa (+)            
 AND    R.TIPOUHESTADIA   = T.IDTIPOUH                                                                                                      
 AND    R.TIPOUHTARIFA    = TRUH.IDTIPOUH                                                                                                    
 AND    M.IDRESERVASFRONT = R.IDRESERVASFRONT                                                                                                
 AND    M.IDHOSPEDE       = H.IDHOSPEDE                                                                                                      
 AND    R.IDHOTEL         = TAR.IDHOTEL (+)                                                                    
 AND    R.STATUSRESERVA   = STAT.STATUSRESERVA                                                                                              

 AND R.IDHOTEL           = U.IDHOTEL                (+)
 AND R.CODUH             = U.CODUH                  (+)
 AND R.CLIENTERESERVANTE = CLI.IDPESSOA             (+)
 AND R.CLIENTEHOSPEDE    = PO.IDPESSOA              (+)
 AND R.IDPACOTE          = PAC.IDPACOTE             (+)
 AND R.IDHOTEL           = PAC.IDHOTEL              (+)
 AND R.IDROOMLIST        = RL.IDROOMLIST            (+)
 AND RL.IDRESERVAGRUPO   = RG.IDRESERVAGRUPO        (+)
 AND R.IDHOTEL           = CONT.IDHOTEL             (+)
 AND R.CLIENTERESERVANTE = CONT.IDFORCLI            (+)
 AND R.CONTRATOINICIAL   = CONT.CODCONTRATO         (+)
 AND R.IDRESERVASFRONT   = AGENDA.IDRESERVASFRONT   (+)
 AND M.IDRESERVASFRONT   = MENSAGEM.IDRESERVASFRONT (+)
 AND M.IDHOSPEDE         = MENSAGEM.IDDESTINATARIO  (+)
 AND H.IDFAIXAETARIA     = FX.IDFAIXAETARIA         (+)
 
 ) WHERE 1=1";


  // Prepara a consulta
$stmt = oci_parse($connection, $sql);

// Executa a consulta
oci_execute($stmt);

// Exibe os resultados
echo "<h2>Informações da Reserva</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr>
        <th>NUMRESERVA</th>
        <th>STATUSRESERVA</th>
        <th>NOMEHOSPEDE</th>
        <th>TIPOHOSPEDE</th>
        <th>RAZAOSOCIAL</th>
        <th>CLIENTE</th>
        <th>NOMEHOSPEDECOMPLETO</th>
        <th>DATACHEGPREVISTA</th>
        <th>OBSERVACOES</th>
      </tr>";

// Itera sobre os resultados e exibe-os na tabela
while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['NUMRESERVA']) . "</td>";
    echo "<td>" . htmlspecialchars($row['STATUSRESERVA']) . "</td>";
    echo "<td>" . htmlspecialchars($row['NOMEHOSPEDE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['TIPOHOSPEDE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['RAZAOSOCIAL']) . "</td>";
    echo "<td>" . htmlspecialchars($row['CLIENTE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['NOMEHOSPEDECOMPLETO']) . "</td>";
    echo "<td>" . htmlspecialchars($row['DATACHEGPREVISTA']) . "</td>";
    echo "<td>" . htmlspecialchars($row['OBSERVACOES']) . "</td>";
    echo "</tr>";
}

echo "</table>";

// Libera os recursos e fecha a conexão
oci_free_statement($stmt);
oci_close($connection);

?>

</body>
</html>