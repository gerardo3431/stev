'use strict';

$(function(){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	var estudio = $('#selectEstudio').select2({ 
		placeholder: 'Busca estudio',
		maximumSelectionLength: 1,
		minimumInputLength: 3,
		ajax: {
			url: '/stevlab/catalogo/getEstudios',
			type: 'get',
			delay: '200',
			data: function(params){
				return{
					_token: CSRF_TOKEN,
					q: params.term,
				}
			},
			processResults: function (data) {
				// console.log(data);
				var listEstudios = [];
				data.forEach(function(element, index){
					let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion}`};
					listEstudios.push(est_data);
				});
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: listEstudios
				};
			}
		}
	});

});