<?php 
    include "../conexion.php";
    date_default_timezone_set('America/Lima');

    $CodExp = (isset($_POST["CodExp"])) ? $_POST["CodExp"] : "";
    $NomProc = (isset($_POST["NomProc"])) ? $_POST["NomProc"] : "";
    $IDP = (isset($_POST['IDP'])) ? $_POST['IDP'] : 0;
    $Est = 'Finalizado';
    $tsql = "{call UpdateProcedimiento (?,?,?)}";
    $params = array($CodExp,$IDP,$Est);
    $stmt = sqlsrv_query($conn,$tsql,$params);
    $tsql = "SELECT C.Correo FROM Expediente AS E INNER JOIN Cliente AS C ON E.Cliente_Representado = C.ID_Cliente WHERE E.Cod_Expediente = '$CodExp'";
    $stmt = sqlsrv_query($conn,$tsql);
    $data = '';
    while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $data .= $row['Correo'].')';
    }
    $time = date('h').':'.date('i').' '.date('A');
    $data .= "Actualizacion de estado del caso)Ha habido una nueva actualizacion en el expediente *".$CodExp."*<br>Se ha finalizado la accion '".$NomProc."' el dia de hoy a las ".$time;
    echo $data;
?>