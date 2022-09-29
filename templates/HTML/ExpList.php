<!DOCTYPE html>
<html lang="en">
<?PHP
    //include_once "../functions/conexion.php";
    
   
    session_start();
    $UserdataRow = explode(',',$_SESSION['DATOSUSER']);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu desplegable</title>
    <link rel="stylesheet" href="../../resources/css/menu.css">
    <link rel="stylesheet" href="../../static/adminlte.min.css">
    <script src="https://kit.fontawesome.com/03a89292db.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/datatables.css"/>
</head>

<body>
    <input type="hidden" name="username" id="username" value="<?php echo $UserdataRow[1]?>">
    <nav class="navbar navbar-expand navbar-dark navbar-cyan justify-content-end">
        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" id="MainPage" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown">Expedientes</a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item bg-cyan" id="ExpCreatePage">Crear Expedientes</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item bg-cyan" id="ExpListPage">Revisar Expedientes</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item bg-cyan" id="AcrUpload">Agregar Archivos</a>
                </div>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link" id="ProcPage">Procedimientos</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown"><?php echo $UserdataRow[2]?></a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item bg-cyan" id="CloseSession">Cerrar Sesion</a>
                </div>
            </li>
        </ul>
    </nav>
    <!--<header class="encabezado">
        <nav class="menu" id="menu">
            <ul class="lista">
                <li class="listItem"><a class="item" href="#" id="MainPage">Inicio</a></li>
                <li class="listItem">
                    <a class="item" href="#">Expedientes</a>
                    <ul class="slide">
                        <li><a id="ExpCreatePage" href="#">Crear Expedientes</a></li>
                        <li><a id="ExpListPage" href="#">Revisar Expedientes</a></li>
                    </ul>
                </li>
                <li class="listItem">
                    <a class="item" href="#" id="ProcPage">Procesos</a>
                </li>
                <li class="listItem">
                    <a class="item" href="#"><?php echo $UserdataRow[2]?></a>
                    <ul class="slide">
                        <li><a id="CloseSession" href="#">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="boton__div">
            <button id="boton"><i class="fas fa-bars"></i></button>
        </div>
    </header>-->
    <!-- Contenido -->
    <div style="margin-top:2%; margin-left: 2%; margin-right: 2%;" class="row">
        <div class="col-12">
            <table class="table table-stripped" id="ExpTable">
                <thead>
                    <tr>
                        <th></th>
                        <th>Expedientes</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!--<div class="col-4">
            <table class="table table-stripped" id="ExpInfo">
                <thead>
                    <td>
                        <th>Informacion del Expediente</th>
                    </td>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>-->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/datatables.js"></script>
    <script src="../../static/bootstrap.bundle.min.js"></script>
    <!--<script src="../resources/js/menu.js"></script>-->
    <script src="../../resources/js/Abog/routingAbog.js"></script>
    <script src="../../resources/js/Abog/ListExp.js"></script>
</body>

</html>