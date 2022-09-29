<?PHP

    include "../../functions/conexion.php";

    $IDA = (isset($_POST['IDA'])) ? $_POST['IDA'] : "";
    //$IDA = 'QV9tYXJr';
    $data = '{"data":[ ';
    $tsql = "SELECT Cod_Expediente FROM Expediente where Abogado_Encargado = '$IDA'";
    $stmt = sqlsrv_query($conn,$tsql);
    while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $exp = trim($row["Cod_Expediente"]);
        $data .= '{';
        $data .= '"EXPEDIENTE":"'.$exp.'"';
        $data .= '},';
    }
    $data = substr($data,0, strlen($data) - 1);
    $data .= "]}";
    echo $data;
 
?>