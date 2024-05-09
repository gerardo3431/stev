$(function() {
    'use strict'
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var estudio = $('#id_empresa').select2({
        placeholder: 'Buscar empresas',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getEmpresas',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listEmpresas = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.descripcion}`};
                    listEmpresas.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listEmpresas
                };
            }
        }
    });

    var estudio = $('#id_empresa_edit').select2({
        placeholder: 'Buscar empresas',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getEmpresas',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listEmpresas = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.descripcion}`};
                    listEmpresas.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listEmpresas
                };
            }
        }
    });
    

    var precio = $('#lista_precio').select2({
		placeholder: 'Buscar estudios',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
		placeholder: 'Busca lista de precio',
        dropdownParent: $('#modal_empresa_nueva'),
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

