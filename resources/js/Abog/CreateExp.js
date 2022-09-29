$(document).ready(function(){

    $('#btnExpCreate').click(function(e){
        e.preventDefault();
        Nro = $.trim($('#NroExp').val());
        Dist = $.trim($('#DistExp').val());
        Year = $.trim($('#YearExp').val());
        Ins =  $('#InsExp').find(":selected").val();
        Mat =  $('#MatExp').find(":selected").val();
        NumJ = $.trim($('#NumJExp').val());
        NumC = $.trim($('#NumCExp').val());
        Usu = $.trim($('#username').val());
        Mail = $.trim($('#usermail').val());
        $.ajax({
            url: "../../../functions/Expedientes/CreateExp.php",
            method: "POST",
            data: {Nro:Nro,Dist:Dist,Year:Year,Ins:Ins,Mat:Mat,NumC:NumC,NumJ:NumJ},
            success: function(data){
                alert("Expediente Creado");
                $.ajax({
                    url: "../../../functions/Expedientes/InsertExp.php",
                    method: "POST",
                    data: {Nro:Nro,Dist:Dist,Year:Year,Ins:Ins,Mat:Mat,Usu:Usu,NumC:NumC,NumJ:NumJ,Mail:Mail},
                    success: function(data){
                        $.ajax({
                            url: "../../functions/Notificacion/SendEmail.php",
                            method: "POST",
                            data: {Data:data},
                            success: function(data){
                                alert(data);
                            }
                        })             
                    }
                })
            }
        })
    });

});


