$(function() {
    'use strict';
    var datatable = $('#dataTableEstudios').DataTable({
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
            url: "/stevlab/catalogo/getAllEstudios",
            method: "GET",
            dataSrc: 'data'
        },
        columns: [
            { data: "clave" },
            { data: "descripcion" },
            { data: "condiciones" },
            { data: null, render: function (data) {
                return `
                    <div class="btn-group" role="group" aria-label="Grupo de botones">
                        <a onclick="verEstudio(this)" class='btn  btn-xs btn-icon btn-primary' ><i class="mdi mdi-eye"></i> </a> 
                        <a onclick="editarEstudio(this)" class="btn btn-xs btn-icon  btn-secondary" ><i class="mdi mdi-pencil"></i> </a> 
                        <a onclick="eliminarEstudio(this)" class="btn btn-xs btn-icon  btn-danger" ><i class="mdi mdi-delete-forever"></i> </a>
                    </div>
                `;
            }},
        ],
        columnDefs: [
            { targets: '_all', render: $.fn.dataTable.render.text(), 
                createdCell: function(td, cellData, rowData, row, col) {
                    if (col < datatable.columns().count() - 1) { // omitir la última columna
                        $(td).css('white-space', 'pre-wrap');
                    }
                }
            },
        ],
        processing: true,
        serverSide: true,
    });
    $('#dataTableEstudios').each(function() {
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