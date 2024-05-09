'use strict';
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


$(function() {
    // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var table = $('#dataTableFolioGeneral').DataTable({
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
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });

    table.on( 'click', 'tr' ,function () {
        let valor = $(this).find('td:eq(0)').html();
        // console.log(valor);
        // Obtener observacion general
    
        const response = axios.post('/stevlab/historial/generate-report', {
            _token: CSRF_TOKEN,
            folio: valor,
        })
        .then(res => {
            console.log(res);
            if(res.data.msj){
                // Notificacion
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                icon: 'error',
                title: `${res.data.msj}`
                });
            }else{
                window.open(res['data']['pdf']);

            }
        })
        .catch((err) =>{
            console.log(err);
        });
    
    });
});


function search_patient(){
    // let formulario = $('#searchPatient');

    let busqueda = axios.post('/stevlab/doctor/showPacientes',  {
        data : $('#searchPatient').serializeArray()
    }).then(function(response){
        // console.log(response);
        BindDataTable(response.data);
    }).catch(function(error){
        console.log(error);
    });
}



var BindDataTable = function(response){
    $('#dataTableMetodos').DataTable().destroy();
    var table = $('#dataTableMetodos').DataTable({
        // "order": [ 0, 'desc'],
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
            {data: 'prefolio'},
            {data: 'nombre'},
            {data: 'observaciones'},
            {data: null, render: function(data){
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }},
            {data: null, render: function(data){
                if(data.estado == 'solicitado'){
                    return '<button type="button" onclick="revisaResultados(this)" class="btn btn-primary btn-xs btn-icon"><i class="mdi mdi-paperclip"></i></button>';
                }else{
                    return '';
                }
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "createdRow": function( row, data, dataIndex ) {
            if ( data.estado == "activo" ) { 
                $(row).addClass('table-primary');
            }else{ 
                $(row).addClass('table-success');
            }
        }
    });
}

function revisaResultados(obj){
    // let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let clave = $(obj).parents('tr').find('td:eq(0)').text();

    let busqueda = axios.post('/stevlab/doctor/verifyPrefolio',  {
        data : clave
    }).then(function(response){
        // console.log(response);
        if(response.data.message){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: 'error',
                title: response.data.message,
            });
        }

        if(response.data.pdf){
            window.open(response['data']['pdf']);

        }
        // BindDataTable(response.data);
    }).catch(function(error){
        console.log(error);
    });
}