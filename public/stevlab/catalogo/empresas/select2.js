$(function() {
	'use strict'
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
	
	var precio = $('#lista_precio').select2({
		placeholder: 'Buscar estudios',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
		placeholder: 'Busca lista de precio',
		ajax: {
			url: '/stevlab/catalogo/get-precios',
			type: 'get',
			delay: '200',
			data: function(params){
				return{
					// _token: CSRF_TOKEN,
					q: params.term,
				}
			},
			processResults: function (data) {
                console.log(data);
				var listEstudios = [];
				
				data.forEach(function(element, index){
					let est_data = {id: element.id, text: `${element.descripcion}`};
					listEstudios.push(est_data);
				});

				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: listEstudios
				};
			}
		}
	});

	var precio_edit = $('#lista_precio_edit').select2({
		placeholder: 'Buscar estudios',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
		dropdownParent: $('#modalEditar'),
		placeholder: 'Busca lista de precio',
		ajax: {
			url: '/stevlab/catalogo/get-precios',
			type: 'get',
			delay: '200',
			data: function(params){
				return{
					// _token: CSRF_TOKEN,
					q: params.term,
				}
			},
			processResults: function (data) {
                console.log(data);
				var listEstudios = [];
				
				data.forEach(function(element, index){
					let est_data = {id: element.id, text: `${element.descripcion}`};
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