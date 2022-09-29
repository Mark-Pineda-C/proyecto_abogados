$(document).ready(function(){

    $('#formArc').on("submit",function(e){
        e.preventDefault();
        CaseID = $('#CaseID').find(":selected").text();
        CaseDescription = $.trim($('#CaseDesc').val());
        ArchiveType = $.trim($('#ArcType').val());
        Op = $.trim($('#op').val());
        Filename = $('#ArcFile').val().toString();
        str = Filename.split('\\');
        var form = new FormData(document.getElementById("formArc"));
        form.append("dato", "valor");
        $.ajax({
            url: "../../functions/Archivos/Create.php",
            method: "POST",
            dataType: "html",
            data: form,
            cache: false,
            contentType: false,
	        processData: false,
            success: function(){
                $.ajax({
                    url: "../../functions/Archivos/UploadArchivo.php",
                    method: "POST",
                    data: {
                        CaseID:CaseID,
                        CaseDescription:CaseDescription,
                        ArchiveType:ArchiveType,
                        ArchiveFile:str[2],
                        OP:Op
                    },
                    success: function(data){
                        alert("archivo subido");
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
    })

    /*$('#InsArc').click(function(e){
        e.preventDefault();
        Filename = $('#ArcFile').val().toString();
        str = Filename.split('\\');
        $.ajax({
            url: "../../funciones/archivos/List.php",
            method: "POST",
            data: {Filename:str[2]},
            success: function(data){
                alert("exito");
            }
        })
    })*/
});