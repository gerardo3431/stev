// function renderiza(data){
//     'use strict';
//     var tabla;
    
//     if ($.fn.DataTable.isDataTable('#dataTableMovimientos')) {
//         $('#dataTableMovimientos').DataTable().destroy();
//     }

//     var ajaxUrl = "/stevlab/almacen/getMovementsRequests";
//     var ajaxDataSrc = '';

//     if (data) {
//         ajaxUrl = ""; // Set to empty string to disable AJAX
//         ajaxDataSrc = data;
//     }

//     tabla = $('#dataTableMovimientos').DataTable({
//         processing: true,
//         // responsive: true,
//         "aLengthMenu": [
//             [10, 30, 50, -1],
//             [10, 30, 50, "All"]
//         ],
//         "iDisplayLength": 10,
//         language: {
//             url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
//         },
//         ajax: {
//             url: ajaxUrl,
//             method: "GET",
//             dataType: "json",
//             dataSrc: ajaxDataSrc,
//             // success: function(resultado){
//             //     console.log(resultado);
//             // }
//         },
//         columns: [
//             { data: "clave" },
//             { data: "descripcion" },
//             { data: "ubicacion" },
//             { data: null, render: function(data){
//                 return data.pivot.cantidad;
//             }},
//             { data: "requested" },
//             { data: "approved" },
//             { data: null, render: function(data){
//                 return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss');
//             }},
//         ],
//         columnDefs: [
//             { targets: '_all', render: $.fn.dataTable.render.text(), 
//                 createdCell: function(td, cellData, rowData, row, col) {
//                     $(td).css('white-space', 'pre-wrap');
//                 }
//             },
//         ]
//     });
//     tabla.each(function() {
//         var datatable = $(this);
//         // SEARCH - Add the placeholder for Search and Turn this into in-line form control
//         var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
//         search_input.attr('placeholder', 'Search');
//         search_input.removeClass('form-control-sm');
//         // LENGTH - Inline-Form control
//         var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
//         length_sel.removeClass('form-control-sm');
//     });
// }