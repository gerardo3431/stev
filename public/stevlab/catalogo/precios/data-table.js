$(function() {
    'use strict';
    
    $(function() {
        $('.dataTablePrecios').DataTable({
            responsive: true,
            "aLengthMenu": [
                [10, 30, 50, -1],
                [10, 30, 50, "All"]
            ],
            "iDisplayLength": 10,
            "language": {
                search: ""
            },
            columnDefs: [
                { targets: '_all', render: $.fn.dataTable.render.text(), 
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).css('white-space', 'wrap');
                    }
                },
            ]
        });
        $('.dataTablePrecios').each(function() {
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
    
    // $('#dataTableEstudios').DataTable( {
        
    //     deferRender:    true,
    //     scrollY:        200,
    //     scrollCollapse: true,
    //     scroller:       true
    // } );
    // $('#dataTableEstudios').each(function() {
    //     var datatable = $(this);
    //     // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    //     var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    //     search_input.attr('placeholder', 'Search');
    //     search_input.removeClass('form-control-sm');
    //     // LENGTH - Inline-Form control
    //     var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    //     length_sel.removeClass('form-control-sm');
    // });
});


function rellenaTablaEstudios(obj){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let id = obj;
    let data = new FormData();
    
    data.append('_token', CSRF_TOKEN);
    data.append('id', id);

    $.ajax({
        url: '/stevlab/catalogo/get-lista',
        type: 'post',
        data: data,
        contentType: false,
        processData: false,
        success: function(response) {
            // console.log(JSON.parse(response));
            let data = JSON.parse(response);
            data.forEach(element => {
                rellena_tablita(element);
            });
            // BindDataTable(JSON.parse(response));
        },
        error: function (jqXHR, textStatus) {
            let responseText = jQuery.parseJSON(jqXHR.responseText);
            console.log(responseText);
        }
    });
}


function rellena_tablita(element ,tipo){
    console.log(tipo);
    let tipo_estudio =  (element.tipo != undefined )  ? element.tipo : tipo ;
    // console.log(element.tipo);
    let tr = `  <tr >
                    <td>
                        ${element.clave}
                    </td>
                    <td style="white-space: inherit;">
                        ${element.descripcion}
                    </td>
                    <td>
                        ${tipo_estudio}
                    </td>
                    <td>
                        <input class="form-control" type="number" value='${element.precio}'></input>
                    </td>
                    <td>
                        <button  onclick='removeEstudio(this)' type="button" class="btn btn-xs btn-danger">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>`;

    if(tipo_estudio == 'Estudio'){
        $('#listPreciosEstudios').prepend(tr);

    }else if(tipo_estudio == 'Perfil'){
        $('#listPreciosProfiles').prepend(tr);
    }else{
        $('#listPreciosImagenologia').prepend(tr);
    }

}

// var BindDataTable = function(response){
//     // console.log(response);
//     $('#dataTableEstudios').DataTable().destroy();
//     $('#dataTableEstudios').DataTable({
//         "order": [ 0, 'desc'],
//         responsive: true,
//         "aLengthMenu": [
//             [10, 30, 50, -1],
//             [10, 30, 50, "All"]
//         ],
//         "iDisplayLength": 10,
//         "language": {
//             search: ""
//         },
//         data: response,
//         columns: [
//             {data: 'clave'},
//             {data: 'descripcion'},
//             {data: 'tipo'},
//             {data: null, render: function(response){
//                 return `<input class="form-control" type="number" value='${response.precio}'></input>`
//             }},
//             {data: null, render: function(data){
//                 return `<button  onclick='removeEstudio(this)' type="button" class="btn btn-xs btn-danger btn-icon delete"><i class="mdi mdi-delete"></i></button>`
//             }}
//         ],
//         language:{ 
//             url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
//         }
//     });
// }
