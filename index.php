<!DOCTYPE html>
<?php
    session_start();
    session_destroy();
?>
<html>
    <head>
        <title>Start Page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="resources/css/login.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="bodyBackground">
        <div class="center">
            <h1>Inicio de Sesion</h1>
            <form id="formLogin">
                <div class="txt_field">
                    <input type="text" required id="user">
                    <label>Nombre de Usuario</label>
                </div>
                <div class="txt_field">
                    <input type="password" required id="pswd">
                    <label>Contraseña</label>
                </div>
          
                <input type="submit" value="Ingresar">
                <div class="signup_link">
                    
                </div>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="resources/js/login.js"></script>
    </body>
</html>
