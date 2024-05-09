'use strict';

$(function(){
    $('#dataTableMetodos').on( 'click', 'tr' ,function () {
        let folio = $(this).find('td:eq(0)').html();
        if($.isNumeric(folio) == true){
            modal_pago(folio);

        }
    });
    
    $('.consultaEstudios').on('change', function(){
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        
        let fecha_inicio    = $('#select_inicio').val();
        let fecha_final     = $('#select_final').val();
        let sucursal        = $('#select_sucursal').val();
        
        let data = new FormData();
        
        data.append('_token', CSRF_TOKEN);
        data.append('fecha_inicio', fecha_inicio);
        data.append('fecha_final', fecha_final);
        data.append('sucursal', sucursal);
        
        $.ajax({
            url: '/stevlab/recepcion/consulta-folios-pendientes',
            type: 'post',
            data: data,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                BindDataTable(JSON.parse(response));
            },
            error: function (jqXHR, textStatus) {
                let responseText = jQuery.parseJSON(jqXHR.responseText);
                console.log(responseText);
            }
        });
        
        // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Actualizando busqueda'
        });
    
    });
});


var BindDataTable = function(response){
    $('#dataTableMetodos').DataTable().destroy();
    $('#dataTableMetodos').DataTable({
        "order": [ 0, 'desc'],
        responsive: true,
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
            search: ""
        },
        data: response,
        columns: [
            {data:   'id'},
            {data: 'folio'},
            {data: null, render: function(data){
                return data.paciente[0].nombre
            }},
            {data: null, render: function(data){
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });
}

