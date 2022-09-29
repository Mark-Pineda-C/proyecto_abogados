<?php
    include "../conexion.php";

    $UserID = (isset($_POST['IDUser'])) ? $_POST['IDUser'] : '';
    $tsql = '{call obtenerUsuario (?)}';
    $params = array($UserID,SQLSRV_PARAM_IN);
    $stmt = sqlsrv_query($conn,$tsql,$params);
    $data = 'data,';
    while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){
        $data .= $row[0].','.$row[1].','.$row[2].','.$row[3].','.$row[4].','.$row[5];
    }
    $tsql = '{call NivelAcceso (?,?)}';
    $params = array(
        array($UserID,SQLSRV_PARAM_IN),
        array(&$NivelAcc,SQLSRV_PARAM_OUT,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR))
    );
    $stmt = sqlsrv_query($conn,$tsql,$params);
    echo $NivelAcc;
    session_start();
    $_SESSION['DATOSUSER'] = $data;
?>