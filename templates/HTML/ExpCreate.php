<!DOCTYPE html>
<html lang="en">
<?PHP
    include_once "../../functions/conexion.php";
    session_start();
    $UserdataRow = explode(',',$_SESSION['DATOSUSER']);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu desplegable</title>
    <link rel="stylesheet" href="../../resources/css/menu.css">
    <link rel="stylesheet" href="../../static/adminlte.min.css">
    <script src="https://kit.fontawesome.com/03a89292db.js" crossorigin="anonymous"></script>    
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

    <div style="margin-top:2%; margin-left: 2%; margin-right: 2%;">
        <div class="card card-outline-primary">
            <div class="card-header">
                <div class="card-title">Insertar Nuevo Expediente</div>
            </div>
            <form id="formExpCreate">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Numero de Expediente: </label>
                                <input type="text" id="NroExp" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Distrito Judicial: </label>
                                <input type="text" id="DistExp" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Numero de Carpeta:</label>
                                <input type="text" id="NumCExp" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Año del expediente: </label>
                                <input type="text" id="YearExp" class="form-control">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Numero de Juzgado:</label>
                                <input type="text" id="NumJExp" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Juzgado: </label>
                                <select id="InsExp" class="form-control">
                                    <option value="0">-</option>
                                    <?php
                                        while($rowJ = sqlsrv_fetch_array($stmtJuzgado,SQLSRV_FETCH_ASSOC)){
                                    ?>
                                    <option value="<?php echo $rowJ['Codigo']?>"><?php echo $rowJ['Juzgado']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Materia: </label>
                                <select id="MatExp" class="form-control">
                                <option value="0">-</option>
                                    <?php
                                        while($rowM = sqlsrv_fetch_array($stmtMateria,SQLSRV_FETCH_ASSOC)){
                                    ?>
                                    <option value="<?php echo $rowM['Codigo']?>"><?php echo $rowM['Materia']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Correo del cliente:</label>
                        <input type="email" id="usermail" class="form-control">
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <input type="button" value="Crear Expediente" id="btnExpCreate" class="btn btn-outline-primary btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../static/bootstrap.bundle.min.js"></script>
    <script src="../../resources/js/Abog/CreateExp.js"></script>
    <!--<script src="../resources/js/menu.js"></script>-->
    <script src="../../resources/js/Abog/routingAbog.js"></script>
</body>

</html>