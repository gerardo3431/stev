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
    // Activa pero no procesa nada hasta que se seleccione un select normalito en el formulario anterior
    var article = $('#listArticles').select2({
        placeholder: 'Buscar articulo',
    });
    article.on("select2:opening", function(evento){
        if($('#ubicacion').val() != ""){
            return true;
        }else{
            Toast.fire({
                icon: 'info',
                title: 'Seleccione area en el formulario anterior primero',
            });
            article.empty().val(null).trigger('change');
            evento.preventDefault();
            return false;
        }
    });

    var solicitud = $('#listSolicitudes').select2({
        placeholder: 'Buscar solicitud',
        maximunSelectionLength: 1,
        minimunInputLength: 3,
        ajax:{
            url: '/stevlab/almacen/getRequests',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listSolicitudes = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.folio}`};
                    listSolicitudes.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listSolicitudes
                };
            }
        }
    });
    solicitud.on('select2:select', function(e){
        const soli = axios.get('/stevlab/almacen/getRequests', {
            params:{
                id : e.params.data.id,
            }
        }).then(function(success){
            console.log(success);
            solicitud = success.data;
            
            $('#tableListArticles').empty();
            
            $('#folio').prop('disabled', true);

            //     $('#listArticles').val(null).trigger('change');
            $('#listSolicitudes').val(null).trigger('change');
            $('#folio').val(null).trigger('change');

            var option = new Option(solicitud.folio, solicitud.id, true, true);
            $('#folio').append(option).trigger('change');

            var fecha = new Date(solicitud.created_at);
            var fechaLegible = fecha.toLocaleDateString();
            $('#fecha').datepicker('setDate',fechaLegible);
            $('#estatus').val(solicitud.tipo);
            
            $('#observaciones').val(solicitud.observaciones);
            $('#estado').val(solicitud.tipo);
            $('#tipo').val(solicitud.solicitud);
            
            if(solicitud.tipo == 'cerrado'){
                $('#estado').prop('disabled', true);
                $('#addRequest').prop('disabled', true);
            }else{
                $('#estado').prop('disabled', false);
                $('#addRequest').prop('disabled', false);
            }

            if(solicitud.articles){
                add_article(solicitud.articles);
            }
            // $('#clave').val()
            // $('#listArticles').select2('data')[0].text
            // $('#unidad').val()
            // $('#ubicacion').val()
            // $('#cantidad').val()
            // $('#existencia').val()
            // $('#solicitud').val()

        }).catch(function(error){
            console.log(error);
        }).finally(function(){

        });
    });

    var folio = $('#folio').select2({
        placeholder: 'Buscar solicitud',
        maximunSelectionLength: 1,
        minimunInputLength: 3,
        ajax:{
            url: '/stevlab/almacen/getRecepcions',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listSolicitudes = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.folio}`};
                    listSolicitudes.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listSolicitudes
                };
            }
        }
    });
    folio.on('select2:select', function(prevent){
        console.log(prevent);
    });
    // var article = $('#listArticles').select2({
    //     placeholder: 'Buscar articulo',
    //     maximumSelectionLength: 1,
    //     minimumInputLength: 3,
    // });
    // article.on("select2:opening", function(evento){
    //     if($('#ubicacion').val() != ""){
    //         return true;
    //     }else{
    //         Toast.fire({
    //             icon: 'info',
    //             title: 'Seleccione area en el formulario anterior primero',
    //         });
    //         article.empty().val(null).trigger('change');
    //         evento.preventDefault();
    //         return false;
    //     }
    // });
    // article.on('select2:select', function(e) {
    //     console.log(e.params.data);
    //     var data = e.params.data;
    //     // $('#listArticles').append(data.text).trigger('change');
    //     // checkArticle(data.id);
    //     axios.get('/stevlab/catalogo/get-article', {
    //         params: {
    //             _token: CSRF_TOKEN,
    //             idArticle: data.id,
    //         }
    //     })
    //     .then(function (response) {
    //         console.log(response);
    //         let articulo = response.data;
    //         $("#clave").val(articulo.clave);

    //         // renderiza();
    //     })
    //     .catch(function (error) {
    //     console.log(error);
    //     })
    //     .finally(function () {
    //     // always executed
    //     });  
    // });
    // article.on('select2:unselect', function (e) {
    //     // Limpia el campo al deseleccionar un elemento
    //     $('#listArticles').val(null).trigger('change');

    //     $("#caducidad").attr('disabled', true);
    //     $("#lote").attr('disabled', true);
    // });
});


// $('#myForm')[0].reset();


// function checkArticle(identificador){
//     console.log(identificador);
//     axios.get('/user', {
//         params: {
//             _token: token,
//             idArticle: identificador
//         }
//     })
//     .then(function (response) {
//     console.log(response);
//     })
//     .catch(function (error) {
//     console.log(error);
//     })
//     .finally(function () {
//     // always executed
//     });  
// }

 // $('#id_paciente').on('select2:select', function(e){
    //     let paciente = $('#id_paciente').val()[0];

    //     check_paciente(paciente, CSRF_TOKEN);
    // });

    // var option = new Option('AQC - A QUIEN CORRESPONDA', '1', true, true);
    // $('#id_doctor').append(option).trigger('change');