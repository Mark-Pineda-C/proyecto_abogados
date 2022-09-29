<?php

    include "../conexion.php";

    $CE = (isset($_POST["CE"])) ? $_POST["CE"] : "";
    $NP = (isset($_POST["NP"])) ? $_POST["NP"] : "";
    $FP = (isset($_POST["FP"])) ? $_POST["FP"] : "";

    $tsql = "{call InsertProcedimiento (?,?,?)}";
    $params = array($CE,$NP,$FP);
    $stmt = sqlsrv_query($conn,$tsql,$params);
    $tsql = "SELECT C.Correo FROM Expediente AS E INNER JOIN Cliente AS C ON E.Cliente_Representado = C.ID_Cliente WHERE E.Cod_Expediente = '$CE'";
    $stmt = sqlsrv_query($conn,$tsql);
    $data = '';
    while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $data .= $row['Correo'].')';
    }
    $data .= "Actualizacion de estado del caso)Ha habido una nueva actualizacion en el expediente *".$CE."*<br>Se ha añadido la accion '".$NP."' con plazo hasta ".$FP;
    echo $data;
?>