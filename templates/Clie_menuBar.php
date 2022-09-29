<!DOCTYPE html>
<html lang="en">
<?PHP
    session_start();
    $UserdataRow = explode(',',$_SESSION['DATOSUSER']);
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu desplegable</title>
    <link rel="stylesheet" href="../resources/css/menu.css">
    <link rel="stylesheet" href="../static/adminlte.min.css">
    <script src="https://kit.fontawesome.com/03a89292db.js" crossorigin="anonymous"></script>
</head>

<body>
    <input type="hidden" name="username" value="<?php echo $UserdataRow[1]?>">
    <nav class="navbar navbar-expand navbar-dark navbar-cyan justify-content-end">
        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" id="MainPage" class="nav-link">Inicio</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown">Archivos</a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item bg-cyan" id="ArcUploadPage">Subir Archivos</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item bg-cyan" id="ArcListPage">Revisar Archivos</a>
                </div>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" id="DataPage" class="nav-link">Mis Datos</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" data-toggle="dropdown">
                    <?php 
                        if($UserdataRow[2] == "") echo "Usuario";
                        else echo $UserdataRow[2];
                    ?>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item bg-cyan" id="CloseSession">Cerrar Sesion</a>
                </div>
            </li>
        </ul>
    </nav>
    <!--<header class="encabezado">
        <nav class="menu" id="menu">
            <ul class="lista">
                <li class="listItem"><a class="item" id="MainPage" href="#">Inicio</a></li>
                <li class="listItem">
                    <a class="item" href="#">Archivos</a>
                    <ul class="slide">
                        <li><a href="#" id="ArcUploadPage">Subir Archivos</a></li>
                        <li><a href="#" id="ArcListPage">Leer Archivos</a></li>
                    </ul>
                </li>
                <li class="listItem">
                    <a class="item" href="#"><?php 
                        if($UserdataRow[2] == "") echo "Usuario";
                        else echo $UserdataRow[2];
                    ?></a>
                    <ul class="slide">
                        <li><a href="#" id="DataPage">Datos</a></li>
                        <li><a id="CloseSession" href="#">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="boton__div">
            <button id="boton"><i class="fas fa-bars"></i></button>
        </div>
    </header>-->

    <img src="../resources/img/JADEC S.A.jpg" style="width: 100%;">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../static/bootstrap.bundle.min.js"></script>
    <!--<script src="../resources/js/menu.js"></script>-->
    <script src="../resources/js/Clie/routingClie.js"></script>
</body>

</html>