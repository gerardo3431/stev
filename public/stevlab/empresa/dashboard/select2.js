$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var paciente = $('#paciente').select2({
        placeholder: 'Buscar pacientes',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/doctor/getPacientes',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                console.log(data);
                var listPacientes = [];
                let est_data = {id: data.id, text: `${data.nombre}`};

                listPacientes.push(est_data);   
                // data.forEach(function(element, index){
                //     let est_data = {id: element.id, text: `${element.nombre}`};
                //     listPacientes.push(est_data);
                // });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listPacientes
                };
            }
        }
    });

});
