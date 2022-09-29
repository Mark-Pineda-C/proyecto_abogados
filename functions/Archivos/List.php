<?php

    include "../conexion.php";

    $CodExp = (isset($_POST["CodExp"])) ? $_POST["CodExp"] : "";
    //$CodExp = '00001-2021-0-JR-FC-01';
    $data = '{ "data":[ ';
    $tsql = "SELECT Archivo, Descripcion FROM Archivo WHERE Cod_Expediente = '".$CodExp."'";
    $stmt = sqlsrv_query($conn,$tsql);
    if($stmt){
        while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
            $dlpage = "<a href='../../functions/Archivos/download.php?Case=".$CodExp."&File=".base64_decode($row["Archivo"])."'>Descargar</a>";
            $data .= "{";
            $data .= '"File":"'.base64_decode($row["Archivo"]).'",';
            $data .= '"Desc":"'.$row['Descripcion'].'",';
            $data .= '"DLPage":"'.$dlpage.'"';
            $data .= '},';
        }
        $data = substr($data,0, strlen($data) - 1);
        $data .= "]}";
        echo $data;
    }else{
        $data .= "{";
        $data .= '"File":"",';
        $data .= '"DLPage":""';
        $data .= '}';
        $data .= "]}";
        echo $data;
    }
    
?>