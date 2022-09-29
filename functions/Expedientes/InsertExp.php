<?php

    include "../../functions/conexion.php";

    $Nro = (isset($_POST["Nro"])) ? $_POST["Nro"] : "";
    $Dist = (isset($_POST["Dist"])) ? $_POST["Dist"] : "";
    $Year = (isset($_POST["Year"])) ? $_POST["Year"] : "";
    $Ins = (isset($_POST["Ins"])) ? $_POST["Ins"] : "";
    $Mat = (isset($_POST["Mat"])) ? $_POST["Mat"] : "";
    $Usu = (isset($_POST["Usu"])) ? $_POST["Usu"] : "";
    $NumC = (isset($_POST["NumC"])) ? $_POST["NumC"] : "";
    $NumJ = (isset($_POST["NumJ"])) ? $_POST["NumJ"] : "";
    $Mail = (isset($_POST["Mail"])) ? $_POST["Mail"] : "";
    $ExpCode = $Nro.'-'.$Year.'-'.$Dist.'-'.$NumC.'-'.$Ins.'-'.$Mat.'-'.$NumJ;
    $Usuario = '';
    $tsql = '{call validarCliente (?,?)}';
    $params = array(
        array($Mail,SQLSRV_PARAM_IN),
        array(&$ValidC,SQLSRV_PARAM_OUT,SQLSRV_PHPTYPE_STRING(SQLSRV_ENC_CHAR))
    );
    $stmt = sqlsrv_query($conn,$tsql,$params);
    if ($ValidC == 'SI'){
        $tsql = '{call insertInfoExp (?,?,?,?,?,?,?,?)}';
        $params = array($ExpCode,$Nro,$Year,$Dist,$NumC,$Ins,$Mat,$NumJ);
        $stmt = sqlsrv_query($conn,$tsql,$params);
        $tsql = '{call insertExpediente (?,?,?)}';
        $params = array($ExpCode,$Usu,$Mail);
        $stmt = sqlsrv_query($conn,$tsql,$params);
        $data = $Mail.')Nuevo Expediente)Se ha creado un nuevo Expediente para usted *Codigo: '.$ExpCode.'*<br>Podra observarlo en nuestra pagina web en cualquier momento';
        echo $data;
    }else if ($ValidC == 'NO'){
        $tsql = '{call verificarYcrearUsuario (?)}';
        $params = array($Mail,SQLSRV_PARAM_IN);
        $stmt = sqlsrv_query($conn,$tsql,$params);
        $tsql = '{call ObetenrUserName (?)}';
        $paras = array($Mail,SQLSRV_PARAM_IN);
        $stmt = sqlsrv_query($conn,$tsql,$params);
        while ($row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_NUMERIC)){
            $Usuario = $row[0];
        }
        $tsql = '{call insertInfoExp (?,?,?,?,?,?,?,?)}';
        $params = array($ExpCode,$Nro,$Year,$Dist,$NumC,$Ins,$Mat,$NumJ);
        $stmt = sqlsrv_query($conn,$tsql,$params);
        $tsql = '{call insertExpediente (?,?,?)}';
        $params = array($ExpCode,$Usu,$Mail);
        $stmt = sqlsrv_query($conn,$tsql,$params);
        $data = $Mail.')Creacion de Expediente)Se ha creado un expediente para usted, el cual podra visualizar en nuestra pagina web: "" con los siguientes datos de accerso.<br>Usuario: '.$Usuario.'<br>Codigo: 12'.$Usuario.'34';
        echo $data;
    }

?>