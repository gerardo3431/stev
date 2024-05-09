'use strict';

// function generaGrafica(){
//     var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
//     let fecha_inicial = $('#fecha_inicial').val();
//     let fecha_final = $('#fecha_final').val();

//     let data = new FormData();
//     data.append('_token', CSRF_TOKEN);
//     data.append('fecha_inicial', fecha_inicial);
//     data.append('fecha_final', fecha_final);

//     $.ajax({
//         url: '/stevlab/recover-chart',
//         type: 'post',
//         data: data,
//         contentType: false,
//         processData: false,
//         success: function(response) {
//             console.log(response);
//             chart.updateSeries([JSON.parse(response)])
//             // BindDataTable(JSON.parse(response));
//         },
//         error: function (jqXHR, textStatus) {
//             let responseText = jQuery.parseJSON(jqXHR.responseText);
//             console.log(responseText);
//         }
//     });

// }