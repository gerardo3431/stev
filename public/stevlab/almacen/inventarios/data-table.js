function renderiza(){
    var tabla;
    'use strict';
    
    if ($.fn.DataTable.isDataTable('#dataTableArticulos')) {
        $('#dataTableArticulos').DataTable().destroy();
    }

    tabla = $('#dataTableArticulos').DataTable({
        processing: true,
        // responsive: true,
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        ajax: {
            url: "/stevlab/almacen/getInventories",
            method: "GET",
            dataSrc: ''
        },
        columns: [
            { data: "id" },
            { data: "folio" },
            { data: "created_at" },
            { data: "ubicacion"},
            { data: "clave"},
            { data: "descripcion"},
            { data: "lote"},
            { data: "caducidad"},
            { data: "cantidad"},

        ],
        columnDefs: [
            { targets: '_all', render: $.fn.dataTable.render.text(), 
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).css('white-space', 'pre-wrap');
                }
            },
        ]
    });
    tabla.each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
}