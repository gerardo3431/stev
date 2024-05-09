$(function() {
    'use strict';

    $('#dataTablePacientes').DataTable({
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
            search: ""
        },
        ajax: {
            url: "/stevlab/catalogo/get-patients",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            dataSrc: 'data'
        },  
        columns: [
            {data: "id", className: "data"},
            {data: "nombre"},
            {data: "fecha_nacimiento"},
            {data: null, render: function(data){
                return `
                    <a onclick='mostrarModal(this)' type="button" class="btn btn-primary btn-xs btn-icon">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                    <a class="btn btn-danger btn-xs btn-icon regis-eliminar" href="paciente-eliminar/${data.id}">
                        <i class="mdi mdi-delete-forever "></i>
                    </a>
                `;
            }}
        ],
        processing: true,
        serverSide: true,
    });
    $('#dataTablePacientes').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
});