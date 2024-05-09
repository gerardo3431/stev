$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    var doctor = $('#listDoctors').select2({
        placeholder: 'Buscar medicos',
        // maximumSelectionLength: 1,
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
    doctor.on('select2:select', function(e){
    });
    doctor.on("select2:opening", function(evento){
        
    });


    var empresa = $('#listEmpresas').select2({
        placeholder: 'Buscar empresas',
        // maximumSelectionLength: 1,
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
    $('#id_empresa').on('select2:select', function(e){
        // console.log(e.params);
        // check_empresa(e.params.data.id, CSRF_TOKEN);
    });
    $('#id_empresa').on('select2:unselecting', function(e){
        // const estudios = axios.get('/stevlab/catalogo/get-lista-estudios', {
        // }).then(function(response){
        //     // console.log(response);
        //     var lista = parse_lista(response.data);
        //     $('#listEstudio').select2('destroy');
        //     $('#listEstudio').empty();
        //     $('#listEstudio').select2({
        //             placeholder: 'Buscar estudios',
        //             data: lista
        //     });
            
        // }).catch(function(error){
        //     console.log(error);
        // });
    });

    // Termina funciones de modales
});