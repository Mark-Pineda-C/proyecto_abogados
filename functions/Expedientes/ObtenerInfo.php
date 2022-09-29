<?PHP
    include '../conexion.php';

    $EXP = (isset($_POST['EXP'])) ? $_POST['EXP'] : "";
    $tsql = "{call ObternerInfo (?)}";
    $params = array($EXP,SQLSRV_PARAM_IN);
    $stmt = sqlsrv_query($conn,$tsql,$params);
    $data = '';
    while($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        
        $data .= "<tr><td><div class='from-group'><label>Numero de Expediente:</label><p>".$row['Nro_Expediente']."</p></div>";
        $data .= "<div class='form-group'><label>Fecha del Expediente:</label><p>".$row['FechaY']."</p></div>";
        $data .= "<div class='from-group'><label>Ubicacion del Expediente:</label><p>".$row['Ubicacion']."</p></div>";
        $data .= "<div class='from-group'><label>Juzgado apelado:</label><p>".$row['Juzgado']."</p></div>";
        $data .= "<div class='from-group'><label>Materia del Caso:</label><p>".$row['Materia']."</p></div>";
        $data .= "<div class='from-group'><label>Abogado a cargo del caso:</label><p>".$row['Abogado']."</p></div>";
        if ($row['Proce']==""){
            $data .= "<div class='from-group'><label>Ultima actualizacion:</label><p>Recien Creado</p></div></td></tr>";
        }else{
            $data .= "<div class='from-group'><label>Ultima actualizacion:</label><p>".$row['Proce']."</p></div></td></tr>";
        }
        
    }
    echo $data;
?>