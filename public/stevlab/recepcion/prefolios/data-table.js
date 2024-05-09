'use strict';

$(function(){
    var table = $('#dataTablePrefolios').DataTable({
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
        },
        ajax: {
            url: "/stevlab/recepcion/get-prefolios",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            dataSrc: 'data'
        },
        columns:[
            {data: 'id'},
            {data: 'prefolio'},
            {data: null, render: function (data){
                return `<span>${data.nombre}</span>`;
            }},
            {data: null, render: function (data){
                return `<span>${data.user[0].name ? data.user[0].name : 'No encontrado'}</span>`;
            }},
            {data: 'created_at'},
            
        ],
        processing: true,
        serverSide: true,
    });
    table.each(function() {
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