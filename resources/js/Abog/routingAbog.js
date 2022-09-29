$(document).ready(function(){
    IDAbogado = $.trim($('#username').val())
    
    $('#MainPage').click(function(){
        window.location.href = '../../../templates/Abog_menuBar.php';
    })

    $('#ExpCreatePage').click(function(){
        window.location.href = '../../../templates/HTML/ExpCreate.php';
    })

    $('#ExpListPage').click(function(){
        window.location.href = '../../../templates/HTML/ExpList.php';
    })

    $('#ProcPage').click(function(){
        $.ajax({
            url : "../../functions/Expedientes/ObtenerExpAbog.php",
            method : "POST",
            data: {IDA:IDAbogado},
            success: function(data){
                window.location.href = "../../templates/HTML/ProcCreate.php";
            }
        })
    })

    $('#AcrUpload').click(function(){
        $.ajax({
            url : "../../functions/Expedientes/ListExp2.php",
            method : "POST",
            data: {IDA:IDAbogado,OP:2},
            success: function(data){
                window.location.href = "../../templates/HTML/AcrUpload.php";
            }
        })
    })

    $('#CloseSession').click(function(){
        window.location.href = '../../../index.php';
    })

})