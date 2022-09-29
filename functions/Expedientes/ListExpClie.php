<?php 

    include "../../functions/conexion.php";

    $IDC = (isset($_POST['IDC'])) ? $_POST['IDC'] : "";
    //$IDA = 'QV9tYXJr';
    $data = '{"data":[';
    $tsql = "SELECT Cod_Expediente FROM Expediente where Cliente_Representado = '$IDC'";
    $stmt = sqlsrv_query($conn,$tsql);
    
    while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $btn = "<a href='#' class='InfoExp'>Ver Informacion</a>";
        $exp = trim($row["Cod_Expediente"]);
        $data .= '{';
        $data .= '"EXPEDIENTE":"'.$exp.'", ';
        $data .= '"DAT":"'.$btn.'"';
        $data .= '},';
    }
    $data = substr($data,0, strlen($data) - 1);
    $data .= "]}";
    echo $data;

?>