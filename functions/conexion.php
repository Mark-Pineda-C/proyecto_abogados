<?php

$serverName = "DESKTOP-CJAVU8G\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"DBAbogado");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

/* Consultas basicas */

$tsqlJuzgado = "SELECT * FROM Juzgados";
$stmtJuzgado = sqlsrv_query($conn,$tsqlJuzgado);

$tsqlMateria = "SELECT * FROM Materias";
$stmtMateria = sqlsrv_query($conn,$tsqlMateria);


?>