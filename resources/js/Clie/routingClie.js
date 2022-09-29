$(document).ready(function(){

    $('#MainPage').click(function(){
        window.location.href = '../../../templates/Clie_menuBar.php';
    })

    $('#ArcUploadPage').click(function(){
        IDClie = $.trim($("#username").val());
        $.ajax({
            url: '../../functions/Expedientes/ListExp2.php',
            method: "POST",
            data: {IDC:IDClie,OP:1},
            success: function(data){
                window.location.href = '../../templates/HTML/ArcUpload.php';
            }
        })
    })

    $('#ArcListPage').click(function(){
        window.location.href = '../../templates/HTML/ArcList.php'
    })

    $('#DataPage').click(function(){
        window.location.href = '../../templates/HTML/DatosCliente.php';
    })

    $('#CloseSession').click(function(){
        window.location.href = '../../../index.php';
    })

})