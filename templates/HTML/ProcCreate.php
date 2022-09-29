<!DOCTYPE html>
<html lang="en">
<?PHP
    //include_once "../functions/conexion.php";
    session_start();
    $UserdataRow = explode(',',$_SESSION['DATOSUSER']);
    $ExpdataRow = explode (',',$_SESSION['DATOSEXP']);
    $row = 1;
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu desplegable</title>
    <link rel="stylesheet" href="../../resources/css/menu.css">
    <link rel="stylesheet" href="../../static/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/datatables.css"/>
    <script src="https://kit.fontawesome.com/03a89292db.js" crossorigin="anonymous"></script>    
</head>

<body>
    <input type="hidden" name="username" id="username" value="<?php echo $UserdataRow[1]?>">
    <input type="hidden" name="aa" value="<?php echo count($ExpdataRow)?>">
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

    <div style="margin-top:2%; margin-left: 2%; margin-right: 2%;">
        <form id="ProcForm">
            <div class="form-group">
                <label>Codigo de Expediente</label>
                <select id="CodExp" class="form-control">
                        <option value="0">-</option>
                    <?php while ($row < count($ExpdataRow)){?>
                        <option><?php echo trim($ExpdataRow[$row])?></option>
                    <?php $row += 1;}?>
                </select>
            </div>
            <div class="form-group">
                <label>Procedimiento</label>
                <input type="text" id="NomProc" class="form-control">
            </div>
            <div class="form-group">
                <label>Fecha de Plazo</label>
                <input type="date" id="FechaProc" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-outline-primary btn-block" type="submit" id="ProcCreate">Guardar</button>
            </div>
        </form>
    </div>
    <div style="margin-top:2%; margin-left: 2%; margin-right: 2%;">
        <table class="table table-stripped" id="ProcTable">
            <thead>
                <tr>
                    <th>Codigo de Expediente</th>
                    <th>ID</th>
                    <th>Procedimiento</th>
                    <th>Fecha inicio</th>
                    <th>Fecha Plazo</th>
                    <th>Estado</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.3/datatables.js"></script>
    <script src="../../static/bootstrap.bundle.min.js"></script>
    <!--<script src="../resources/js/menu.js"></script>-->
    <script src="../../resources/js/Abog/routingAbog.js"></script>
    <script src="../../resources/js/Abog/Procesos.js"></script>
</body>
</html>