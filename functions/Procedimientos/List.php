<?PHP
    include "../conexion.php";

    $IDA = (isset($_POST["IDA"])) ? $_POST["IDA"] : "";
    //$IDA ='QV9tYXJr';

    $tsql = "SELECT Cod_Expediente FROM Expediente WHERE Abogado_Encargado = '".$IDA."'";
    $stmt = sqlsrv_query($conn,$tsql);
    $data= '{"data":[ ';
    while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $exp = trim($row["Cod_Expediente"]);
        //echo $exp;
        $tsql2 = "SELECT ID_Prod, Nombre_Procedimiento, Fecha_Inicio, Fecha_Plazo, Estado FROM Procedimiento WHERE Cod_Expediente = '".$exp."' ORDER BY Fecha_Inicio desc";
        $stmt2 = sqlsrv_query($conn,$tsql2);
        while ($row2 = sqlsrv_fetch_array($stmt2,SQLSRV_FETCH_ASSOC)){
            $fecha1 = $row2["Fecha_Inicio"]->format('Y-m-d');
            $fecha2 = $row2["Fecha_Plazo"]->format('Y-m-d');
            $data .= '{
                "CODEXP":"'.$exp.'",
                "ID":"'.$row2["ID_Prod"].'",
                "PROCED":"'.$row2["Nombre_Procedimiento"].'",
                "FECINI":"'.$fecha1.'",
                "FECPLA":"'.$fecha2.'",';
            $dateActual = date('Y').'-'.date('m').'-'.date('d');
            $datediff = idate('z',strtotime($fecha2)) - idate('z',strtotime($dateActual));
            $est = $row2['Estado'];
            if ($est == "Finalizado"){
                $data .= '"ESTADO":"Finalizado",';
            }else{
                if ($datediff <= 3 and $datediff > 0){
                    $data .= '"ESTADO":"Proximo a caducar",';
                }else{
                    if ($datediff <= 0){
                        $data .= '"ESTADO":"Caducado",';
                    }else{
                        $data .= '"ESTADO":"Iniciado",';
                    }
                }
            }
            $data .= '"ACCION":"<a href=\"#\" class=\"edit\">Finalizar</a>"},';
        }
        //$data = substr($data,0, strlen($data) - 1);
    }
    $data = substr($data,0, strlen($data) - 1);
    $data .= "]}";
    echo $data;

?>