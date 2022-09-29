<?PHP

    include "../conexion.php";

    $IDA = (isset($_POST["IDA"])) ? $_POST["IDA"] : "";

    $tsql = "SELECT Cod_Expediente FROM Expediente WHERE Abogado_Encargado = '".$IDA."'";
    $stmt = sqlsrv_query($conn,$tsql);
    $data= "data,";
    while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $exp = trim($row["Cod_Expediente"]);
        $data .= $exp.",";
    }
    $data = substr($data,0, strlen($data) - 1);
    echo $data;
    session_start();
    $_SESSION['DATOSEXP'] = $data;
?>