<?php
    include "../conexion.php";

    $CaseID = (isset($_POST['CaseID'])) ? $_POST['CaseID'] : '';
    $CaseDescription = (isset($_POST['CaseDescription'])) ? $_POST['CaseDescription'] : '';
    $ArchiveType = (isset($_POST['ArchiveType'])) ? $_POST['ArchiveType'] : '';
    $ArchiveFile = (isset($_POST['ArchiveFile'])) ? $_POST['ArchiveFile'] : '';
    $OP = (isset($_POST['OP'])) ? $_POST['OP'] : "";
    $File = base64_encode($ArchiveFile);
    $tsql = "{call insertArchivo (?,?,?,?)}";
    $params = array($CaseID,$ArchiveType,$CaseDescription,$File);
    $stmt = sqlsrv_query($conn,$tsql,$params);
    switch($OP){
        case 1:
            $tsql = "SELECT A.Correo FROM Expediente AS E INNER JOIN Abogado AS A ON E.Abogado_Encargado = A.ID_Abogado WHERE E.Cod_Expediente = '$CaseID'";
            $stmt = sqlsrv_query($conn,$tsql);
            $data = '';
            while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                $data .= $row['Correo'].')';
            }
            $data .= 'Actualizacion de Expediente)El cliente ha añadido un nuevo archivo al expediente *'.trim($CaseID).'*<br>Puede revisarlo Accediendo al sistema web.';
            break;
        case 2:
            $tsql = "SELECT C.Correo FROM Expediente AS E INNER JOIN Cliente AS C ON E.Cliente_Representado = C.ID_Cliente WHERE E.Cod_Expediente = '$CaseID'";
            $stmt = sqlsrv_query($conn,$tsql);
            $data = '';
            while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                $data .= $row['Correo'].')';
            }
            $data .= 'Actualizacion de Expediente)El abogado ha añadido un nuevo archivo al expediente *'.trim($CaseID).'*<br>Puede revisarlo Accediendo al sistema web.';
            break;
    }
    echo $data;

?>