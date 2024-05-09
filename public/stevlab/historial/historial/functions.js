'use strict'
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(function(){

    var table = $('#dataTableFolio').DataTable({
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

function searchPatient(obj){
    let paciente = $('#paciente').val()[0];
    let folio    = $('#folio').val();

    const search = axios.post('/stevlab/historial/search-folios', {
        _token: CSRF_TOKEN,
        paciente: paciente,
        folio: folio
    })
    .then(function (response) {
        let dato = response.data;
        const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                    icon: 'success',
                    title: 'Buscando...',
                });
        console.log(response);
        BindDataTable(dato);

    })
    .catch(function (error) {
        console.log(error);
    });
}



// $('.consultaEstudios').on('change', function(){
//     var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
//     let fecha_inicio    = $('#selectInicio').val();
//     let fecha_final     = $('#selectFinal').val();
//     let sucursal        = $('#selectSucursal').val();
//     let estado          = $('#selectEstudio').val();
//     let area            = $('#selectArea').val();
    
//     let data = new FormData();
    
//     data.append('fecha_inicio', fecha_inicio);
//     data.append('fecha_final', fecha_final);
//     data.append('sucursal', sucursal);
//     data.append('estado', estado);
//     data.append('area', area);
    
//     const response = axios.post('/stevlab/captura/consulta-estudios', data ,{
//     }).then(res => {
//         let dato = res.data;
//         BindDataTable(dato);
//     })
//     .catch((err) =>{
//         console.log(err);
//     });
    
//     // Notificacion
//     const Toast = Swal.mixin({
//         toast: true,
//         position: 'top-end',
//         showConfirmButton: false,
//         timer: 3000,
//         timerProgressBar: true,
//     });
    
//     Toast.fire({
//     icon: 'success',
//     title: 'Actualizando busqueda'
//     });

// });