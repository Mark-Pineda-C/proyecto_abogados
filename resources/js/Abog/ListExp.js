$(document).ready(function(){
    IDAbogado = $.trim($('#username').val());

    function createChild(row,exp) {
        // This is the table we'll convert into a DataTable
        var table = $('<table class="display" width="100%"><thead><tr><th>Archivos</th><th>Descripcion</th><th>Accion</th></tr></thead></table>');

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
                {
                    "data":"File",
                    "defaultContent": "sin datos"
                },
                {
                    "data":"Desc",
                    "defaultContent": "sin datos"
                },
                {
                    "data":"DLPage",
                    "defaultContent" : "sin datos"
                }
            ],
            "language":{
                "zeroRecords": "No se han agregado Archivos hasta el momento"
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
            "url" : "../../functions/Expedientes/ListExp.php",
            "method" : "POST",
            "data" : {"IDA" : IDAbogado}
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
            }
        ],
        "language":{
            "zeroRecords": "No se han agregado Expedientes hasta el momento"
        }
        
    });

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
})