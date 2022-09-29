<?php
    include "../conexion.php";

    $UserEmail = (isset($_POST['UserEmail'])) ? $_POST['UserEmail'] : '';
    $UserPassword =(isset($_POST['UserPassword'])) ? $_POST['UserPassword'] : '';
    $tsql='{call ValidarUsuario (?,?,?)}';
    $params= array(
        array($UserEmail,SQLSRV_PARAM_IN),
        array($UserPassword,SQLSRV_PARAM_IN),
        array(&$mensaje,SQLSRV_PARAM_OUT,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR),SQLSRV_SQLTYPE_VARCHAR('max'))
    );
    $stmt = sqlsrv_query($conn,$tsql,$params);
    echo 'resp,'.$mensaje; 
    echo ','.$UserEmail;
?>