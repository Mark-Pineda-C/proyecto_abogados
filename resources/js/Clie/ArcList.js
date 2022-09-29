$(document).ready(function(){
    IDClie = $.trim($('#username').val());

    function createChild(row,exp) {
        // This is the table we'll convert into a DataTable
        var table = $('<table class="display" width="100%"><thead><tr><th>Archivos</th><th>Accion</th></tr></thead></table>');

        // Display it the child row
        row.child( table ).show();
     
        // Initialise as a DataTable
        var usersTable = table.DataTable( {
            "paging":   false,
            "ordering": false,
            "info":     false,
            "searching": false,
            "ajax":{
                "url" : "../../functions/Archivos/List.php",
                "method" : "POST",
                "data": {"CodExp":exp}
            },
            "columns":[
                {"data":"File"},
                {"data":"DLPage"}
            ],
            "language":{
                "zeroRecords": "No se ha agregado ningun Archivo por el momento"
            }
        } );
    }

    function destroyChild(row) {
        var table = $("table", row.child());
        table.detach();
        table.DataTable().destroy();
     
        // And then hide the row
        row.child.hide();
    }

    ExpTable = $('#ExpTable').DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "ajax":{
            "url" : "../../functions/Expedientes/ListExpClie.php",
            "method" : "POST",
            "data" : {"IDC" : IDClie}
        },
        "columns":[
            {
                "className":      'dt-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {
                "data":"EXPEDIENTE"
            },
            {
                "data":"DAT"
            }
        ]
    })

    $('#ExpTable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = ExpTable.row( tr );
        var exp = tr.find("td:eq(1)").text();
        if ( row.child.isShown() ) {
            // This row is already open - close it
            destroyChild(row);
            tr.removeClass('shown');
        }
        else {
            // Open this row
            createChild(row,exp);
            tr.addClass('shown');
        }
    } );

    $(document).on('click','.InfoExp',function(){
        var tr = $(this).closest('tr');
        var exp = tr.find("td:eq(1)").text();
        $.ajax({
            url : '../../functions/Expedientes/ObtenerInfo.php',
            method : "POST",
            data: {EXP:exp},
            success : function(data){
                $('#InfoExp tbody').html(data);
            }
        })
    })

})