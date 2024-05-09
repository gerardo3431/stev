'use strict';
$(function(){
    // renderiza();
    var table = $('#dataTableMovimientos').DataTable({
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
});

// Consulta tablas
$('#search').on('click', function(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
    let fecha_inicio    = $('#selectInicio').val();
    let fecha_final     = $('#selectFinal').val();
    // let folio           = $('#folio').val();
    let estado          = $('#selectEstado').val();
    // console.log(fecha_inicio );
    // console.log(fecha_final );

    // let data = new FormData();
    
    // data.append('fecha_inicio', fecha_inicio);
    // data.append('fecha_final', fecha_final);
    // // data.append('area', area);
    // data.append('estado', estado);
    
    setTimeout(() => {
        const response = axios.get('/stevlab/almacen/getMovementsRequests' ,{
            params:{
                fecha_inicio: fecha_inicio,
                fecha_final: fecha_final,
                // area: area,
                estado: estado,
                // folio : folio
            }
        }).then(res => {
            console.log(res);
            // let dato = res.data;
            BindDataTable(res.data);
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
        }).catch((err) =>{
            console.log(err);
        });
    }, 1000);

});



var BindDataTable = function(response){
    $('#dataTableMovimientos').DataTable().destroy();
    var table = $('#dataTableMovimientos').DataTable({
        "order": [ 0, 'desc'],
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
            {data: null, render: function(data){
                return data.clave
            }},
            {data: null, render: function(data){
                return data.descripcion
            }},
            {data: null, render: function(data){
                return data.ubicacion
            }},
            {data: null, render: function(data){
                return data.pivot.cantidad
            }},
            {data: null, render: function(data){
                return data.requested
            }},
            {data: null, render: function(data){
                return data.approved
            }},
            {data: null, render: function(data){
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
    });
}

