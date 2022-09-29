$(document).ready(function(){
    User = $.trim($('#username').val());

    $('#ActData').click(function(){
        Nombre = $.trim($('#NomCli').val());
        Apellido = $.trim($('#ApeCli').val());
        Dni = $.trim($('#DNICli').val());
        Direccion = $.trim($('#DirCli').val());
        Correo = $.trim($('#MailCli').val());
        $.ajax({
            url : '../../functions/Usuarios/ActualizarInfo.php',
            method : "POST",
            data: {Nom:Nombre,Ape:Apellido,DNI:Dni,Dir:Direccion,User:User,Cor:Correo},
            success : function(data){
                alert("datos Actualizados");
                $.ajax({
                    url:"../../functions/Usuarios/obtenerUsuario.php",
                    type:"POST",
                    datatype:"json",
                    data:{IDUser:User},
                    success: function(){
                        window.location.href = "../../templates/HTML/DatosCliente.php";
                    }
                });
            }

        })
    });

})