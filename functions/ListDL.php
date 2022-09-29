<?php

    include '../functions/conexion.php';

    $CAT = (isset($_POST['CAT'])) ? $_POST['CAT'] : '';
    $CAT .= '%';
    echo $CAT;
    $tsql = "{call ReadSubUbicaciones (?)}";
    $params = array(utf8_encode($CAT),SQLSRV_PARAM_IN,SQLSRV_SQLTYPE_CHAR(80));
    $stmt = sqlsrv_query($conn,$tsql,$params);
    $html = '';
    while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $html .='<option value="'.$row['Codigo'].'">'.$row['Dist'].'</option>';
    }
    echo $html;
?>