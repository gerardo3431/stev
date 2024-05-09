$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var paciente = $('#id_paciente').select2({
        placeholder: 'Buscar pacientes',
        dropdownParent: $('#modal_prefolio'),
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getPacientes',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listPacientes = [];
                // listPacientes.push(paciente);   
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.fecha_nacimiento} - ${element.nombre}`};
                    listPacientes.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listPacientes
                };
            }
        }
    });
    $('#id_paciente').on('select2:select', function(e){
        // let paciente = $('#id_paciente').val()[0];

        // check_paciente(paciente, CSRF_TOKEN);
    });

    // Para los modales
    var medico = $('#id_doctor').select2({
        placeholder: 'Buscar medicos',
        dropdownParent: $('#modal_prefolio'),
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getMedicos',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listMedicos = [];
                // listMedicos.push(doctor);                
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.clave} - ${element.nombre} `};
                    listMedicos.push(est_data);

                    
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listMedicos
                };
            }
        }
        
    });
    // var option = new Option('AQC - A QUIEN CORRESPONDA', '1', true, true);
    // $('#id_doctor').append(option).trigger('change');
    
    var empresa_paciente = $('#id_empresa_paciente').select2({
        dropdownParent: $('#modal_paciente'),
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
                // let empresa = {id: data.id, text: `${data.descripcion}`};
                // listEmpresas.push(empresa);   
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

    // var precio = $('#lista_precio').select2({
    //     dropdownParent: $('#modal_empresa'),
	// 	placeholder: 'Buscar estudios',
    //     maximumSelectionLength: 1,
    //     minimumInputLength: 3,
	// 	placeholder: 'Busca lista de precio',
	// 	ajax: {
	// 		url: '/stevlab/catalogo/get-precios',
	// 		type: 'get',
	// 		delay: '200',
	// 		data: function(params){
	// 			return{
	// 				// _token: CSRF_TOKEN,
	// 				q: params.term,
	// 			}
	// 		},
	// 		processResults: function (data) {
	// 			var listEstudios = [];
				
	// 			data.forEach(function(element, index){
	// 				let est_data = {id: element.id, text: `${element.descripcion}`};
	// 				listEstudios.push(est_data);
	// 			});

	// 			// Transforms the top-level key of the response object from 'items' to 'results'
	// 			return {
	// 				results: listEstudios
	// 			};
	// 		}
	// 	}
	// });
    // Termina funciones de modales
});