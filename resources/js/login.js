$(document).ready(function(){

    $('#formLogin').submit(function(e){
        e.preventDefault();
        usuario = $.trim($('#user').val());
        pswd = $.trim($('#pswd').val());
        $.ajax({
            url:"../../functions/Usuarios/validarUsuario.php",
            type:"POST",
            datatype:"json",
            data:{UserEmail:usuario,UserPassword:pswd},
            success:function(data){
                resp = data.split(',');
                if(resp[1]=="OK"){
                    alert(resp[2]);
                    $.ajax({
                        url:"../../functions/Usuarios/obtenerUsuario.php",
                        type:"POST",
                        datatype:"json",
                        data:{IDUser:resp[3]},
                        success: function(data){
                            if (data == 1){
                                window.location.href="../../templates/Clie_menuBar.php";
                            } else window.location.href="../../templates/Abog_menuBar.php";
                        }
                    });
                } else alert(resp[2]);
            }
        });
    });

});