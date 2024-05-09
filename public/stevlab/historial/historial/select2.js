$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    // Lista de estudios
    var paciente = $('#paciente').select2({
        placeholder: 'Buscar paciente',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getPacientes',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listPacientes = [];
                // listPacientes.push(paciente);   
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.fecha_nacimiento} - ${element.nombre}`};
                    listPacientes.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listPacientes
                };
            }
        }
    });
    $('#paciente').on('select2:select', function(e){
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
    });
});

var BindDataTable = function(response){
    $('#dataTableFolio').DataTable().destroy();
    var table = $('#dataTableFolio').DataTable({
        "order": [ 0, 'desc'],
        // responsive: true,
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
            {data: 'folio'},
            {data: null, render: function(data){
                return data.paciente[0].nombre
            }},
            {data: null, render: function(data){
                return data.sucursales[0].sucursal
            }},
            {data: null, render: function(data){
                return data.empresas.descripcion
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