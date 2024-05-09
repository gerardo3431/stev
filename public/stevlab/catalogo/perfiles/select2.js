// $(function() {
// 	'use strict';
// 	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


// 	var estudio = $("#estudio").select2({
// 		placeholder: 'Buscar estudio',
// 		ajax: {
// 			url: 'getEstudios',
// 			type: 'get',
// 			delay: '200',
// 			data: function(params){
// 				return{
// 					_token: CSRF_TOKEN,
// 					q: params.term,
// 				}
// 			},
// 			processResults: function (data) {
// 				var listEstudios = [];
// 				data.forEach(function(element, index){
// 					let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion}`};
// 					listEstudios.push(est_data);
// 				});
// 				// Transforms the top-level key of the response object from 'items' to 'results'
// 				return {
// 					results: listEstudios
// 				};
// 			}
// 		}
// 	});
// 	$('#estudio').on('select2:select', function (e) {
        
//         let data= e.params.data.id;
//         // Revisame los analitos que ya esten asignados
//         axios.post('/stevlab/catalogo/checkEstudio', {
//             _token: CSRF_TOKEN,
//             data: data,
            
//         })
//         .then(function (response) {
//             // console.log(response);
//             // Para settear los estudios
//             let list =`	<tr>
// 							<th>${response.data.clave}</th>
// 							<td >${response.data.descripcion}</td>
// 							<td>${response.data.condiciones}</td>
// 							<td>
// 								<a onclick='removeEstudio(this)' href="#"><i class="mdi mdi-backspace"></i></a>
// 							</td>
// 						</tr>`;
// 			$('#listEstudios').append(list);
                
//         })
//         .catch(function (error) {
//             console.log(error);
//         });
//     });

	
// });
