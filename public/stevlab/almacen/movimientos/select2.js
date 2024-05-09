$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var folio = $('#folio').select2({
        placeholder: 'Buscar solicitud',
        maximunSelectionLength: 1,
        minimunInputLength: 3,
        ajax:{
            url: '/stevlab/almacen/getRequests',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listSolicitudes = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.folio}`};
                    listSolicitudes.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listSolicitudes
                };
            }
        }
    });
    folio.on('select2:select', function(e){
        // console.log(e.params.data.id);
        const response = axios.get('/stevlab/almacen/getMovementsRequests' ,{
            params:{
                folio : e.params.data.id
            }
        }).then(res => {
            console.log(res);
            // let dato = res.data;
            if(res.data){
                BindDataTable(res.data);
            }
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
    });
});
