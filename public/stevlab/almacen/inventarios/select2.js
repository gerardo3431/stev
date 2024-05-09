$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    var article = $('#listArticles').select2({
        placeholder: 'Buscar articulo',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getArticles',
            type: 'get',
            delay: '200',
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listArticles = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.nombre}`};
                    listArticles.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listArticles
                };
            }
        }
    });

    article.on('select2:select', function(e) {
        console.log(e.params.data);
        var data = e.params.data;
        // $('#listArticles').append(data.text).trigger('change');
        // checkArticle(data.id);
        axios.get('/stevlab/catalogo/get-article', {
            params: {
                _token: CSRF_TOKEN,
                idArticle: data.id
            }
        })
        .then(function (response) {
            console.log(response);
            let articulo = response.data;
            $("#clave").val(articulo.clave);

            if(articulo.caducidad == 'on'){
                $("#caducidad").attr('disabled', false);
            }

            if(articulo.lote == 'on'){
                $("#lote").attr('disabled', false);
            }

            // renderiza();
        })
        .catch(function (error) {
        console.log(error);
        })
        .finally(function () {
        // always executed
        });  
    });

    article.on('select2:unselect', function (e) {
        // Limpia el campo al deseleccionar un elemento
        $('#listArticles').val(null).trigger('change');

        $("#caducidad").attr('disabled', true);
        $("#lote").attr('disabled', true);
        // $("#clave").val("");

    });
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