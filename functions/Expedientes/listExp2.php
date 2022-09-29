<?PHP

    include "../../functions/conexion.php";

    $IDC = (isset($_POST['IDC'])) ? $_POST['IDC'] : "";
    $IDA = (isset($_POST['IDA'])) ? $_POST['IDA'] : "";
    $op = (isset($_POST['OP'])) ? $_POST['OP'] : "";
    switch($op){
        case 1:
            $data = '';
            $tsql = "SELECT Cod_Expediente FROM Expediente WHERE Cliente_Representado = CONVERT(varbinary(80),'$IDC')";
            $stmt = sqlsrv_query($conn,$tsql);
            $data = "data,";
            while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                $data .= $row["Cod_Expediente"].',';
            }
            echo $data;
            session_start();
            $_SESSION['DATOSEXPEDIENTE'] = $data;
            break;
        case 2:
            $data = '';
            $tsql = "SELECT Cod_Expediente FROM Expediente WHERE Abogado_Encargado = CONVERT(varbinary(80),'$IDA')";
            $stmt = sqlsrv_query($conn,$tsql);
            $data .= "data,";
            while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                $data .= $row["Cod_Expediente"].',';
            } 
            echo $data;
            session_start();
            $_SESSION['DATOSEXPEDIENTE'] = $data;
            break;
    }
    

?>