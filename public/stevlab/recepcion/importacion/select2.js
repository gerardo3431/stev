
$(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    'use strict';
	$('.selectEstudio').on('click',function(){
		$(this).select2({ 
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
			},
			// selector: '.selectEstudio'
		});
	});

	$('.selectAnalito').on('click', function(){
		$(this).select2({
			placeholder: 'Busca analito',
			maximumSelectionLength: 1,
			ajax: {
				url: '/stevlab/catalogo/getAnalito',
				type: 'get',
				delay: '200',
				data: function(params){
					return{
						_token: CSRF_TOKEN,
						q: params.term,
					}
				},
				processResults: function (data) {
					var listEstudios = [];
					data.forEach(function(element, index){
						let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - tipo: ${element.tipo_resultado}`};
						
						listEstudios.push(est_data);
					});
					// Transforms the top-level key of the response object from 'items' to 'results'
					return {
						results: listEstudios
					};
				}
			}
		});
	})


	$('.selectFolio').on('click', function(){
		$(this).select2({
			placeholder: 'Busca folio',
			maximumSelectionLength: 1,
			ajax: {
				url: '/stevlab/catalogo/getFolios',
				type: 'get',
				delay: '200',
				data: function(params){
					return{
						_token: CSRF_TOKEN,
						q: params.term,
					}
				},
				processResults: function (data) {
					var listEstudios = [];
					data.forEach(function(element, index){
						let est_data = {id: element.id, text: element.folio};
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
	// $('.selectFolio').on('select2:select', function(e){    
    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //     const selectedValue = e.params.data.id;
		
	// 	const estudios = axios.post('/stevlab/recepcion/recover-estudios-imp', {
	// 		_token: CSRF_TOKEN,
	// 		id: selectedValue
	// 	}).then((success)=>{
	// 		$(this).find('#estudio').empty();

	// 		let estudios = success.data.data;
			
	// 		let label = $(this).parents().find('#estudio');
	// 		console.log(label);
			
	// 		estudios.forEach( (element, key ) => {
	// 			label.empty();
	// 			// console.log(key);
	// 			let opcion = `
	// 				<option value='${element.id}' ${key === 0 ? 'selected' : ''}>${element.descripcion}</option>
	// 			`;
	// 			label.append(opcion);
    //         	// var option = new Option(element.descripcion, element.id, true, true);
    //         	// $('#id_empresa').append(option).trigger('change');
	// 		});
	// 	}).catch((error)=>{

	// 	});
    // });
});