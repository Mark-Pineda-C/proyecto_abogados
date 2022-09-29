$(document).ready(function(){  
    IDAbogado = $.trim($('#username').val());
    ProcTable = $('#ProcTable').DataTable({
        "scrollY":        '50vh',
        "scrollCollapse": true,
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "ajax":{
            "url":"../../functions/Procedimientos/List.php",
            "method":"POST",
            "data":{"IDA":IDAbogado}
        },
        "columns":[
            {"data":"CODEXP",
            "defaultContent":''},
            {"data":"ID",
            "defaultContent":'',
            "visible": false,
            "searchable": false},
            {"data":"PROCED",
            "defaultContent":''},
            {"data":"FECINI",
            "defaultContent":''},
            {"data":"FECPLA",
            "defaultContent":''},
            {"data":"ESTADO",
            "defaultContent":''},
            {"data":"ACCION",
            "defaultContent":''}
        ],
        "language":{
            "zeroRecords": "No se han registrado Procedimientos por el momento"
        }
    });

    $('#ProcCreate').click(function(e){
        e.preventDefault();
        CodExp = $('#CodExp').find(":selected").text();
        NomProc = $.trim($('#NomProc').val());
        FechaProc = $.trim($('#FechaProc').val());
        FechaProc = FechaProc.split('/').reverse().join('-');
        $.ajax({
            url: "../../functions/Procedimientos/Insert.php",
            method: "POST",
            data:{
                CE:CodExp,
                NP:NomProc,
                FP:FechaProc
            },
            success: function(data){
                ProcTable.ajax.reload(null,false)
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
    })

    $(document).on("click",".edit",function(){
        fila = $(this).closest("tr");
        ID_Prod= JSON.stringify(ProcTable.row(fila).data(),["ID"]);
        var resp = ID_Prod.split('"');
        alert(resp[3]);
        CodExp = fila.find("td:eq(0)").text();
        NomProc = fila.find("td:eq(1)").text();
        $.ajax({
            url: "../../functions/Procedimientos/Update.php",
            method: "POST",
            data: {CodExp:CodExp,NomProc:NomProc,IDP:resp[3],OP:1},
            success: function(data){
                $.ajax({
                    url: "../../functions/Notificacion/SendEmail.php",
                    method: "POST",
                    data: {Data:data},
                    success: function(data){
                        alert(data);
                        window.location.href = "../../../templates/HTML/ProcCreate.php";
                    }
                })
            }
        })
    })

})