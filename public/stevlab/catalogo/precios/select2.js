$(function() {
	'use strict'
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
	
	var estudio = $('#list_estudios').select2({
		dropdownParent: $('#detailList'),
        placeholder: 'Agregar estudios',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/recepcion/get_estudios_recepcion',
            type: 'get',
            delay: '200',
            // maximumSelectionLength: 1,
            data: function(params){
                return {
                    _token: CSRF_TOKEN,
                    q: params.term, 
                }
            },
            processResults: function(data){
                var listEstudios = [];
                data.estudios.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - Estudio`};
                    listEstudios.push(est_data);
                });

                data.perfiles.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - Perfil`};
                    listEstudios.push(est_data);
                });

                data.imagenologia.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - Imagenologia`};
                    listEstudios.push(est_data);
                });
                
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listEstudios
                };
            }
        }
        
    });
    $('#list_estudios').on('select2:select', function (e) {
        // console.log(e.params.data.text);
        let descripcion = e.params.data.text.toString().split('-').slice(-1)[0].trim();
        let data= e.params.data.id;
        if(descripcion == 'Estudio'){
            check_estudio(data,  CSRF_TOKEN);
        }else if(descripcion == 'Perfil'){
            check_perfil(data, CSRF_TOKEN);
        }else{
            check_imagenologia(data, CSRF_TOKEN);
        }
        // Resetea el campo select2 a null para prevenir el error de multiple seleccion no especificado.
        $('#list_estudios').val(null).trigger('change');
    });
});

function check_estudio(id, empresa, token){
    axios.post('/stevlab/catalogo/checkEstudio', {
        _token: token,
        data: id,
    })
    .then(function (response) {
        let estudio = response.data;
        // var t = $('#dataTableEstudios').DataTable();
        // Para settear los estudios
        rellena_tablita(response.data, 'Estudio');
    })
    .catch(function (error) {
        console.log(error);
    });
}

function check_perfil(id, empresa, token){
    axios.post('/stevlab/catalogo/checkPerfil', {
        _token: token,
        data: id,
    })
    .then(function (response) {
        let perfil = response.data;
        rellena_tablita(response.data, 'Perfil');


        // console.log(response);
        // Para settear los perfile
        // var t = $('#dataTableEstudios').DataTable();
    
        // t.rows.add( [ {
        //     "clave":        response.data.clave,
        //     "descripcion":  response.data.descripcion,
        //     "tipo":         "Perfil",
        //     "costo":        null, render:function(response){
        //         return `<input id="" name="" class="form-control" type="number" value='${response.data.precio}'></input>`
        //     },
        //     "#":            null, render: function(data){
        //         // return `<a href="#" onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>`
        //         return `<button  onclick='removeEstudio(this)' type="button" class="btn btn-xs btn-danger btn-icon delete"><i class="mdi mdi-delete"></i></button>`
        //     }
        // }])
        // .draw();
    })
    .catch(function (error) {
        console.log(error);
    });
}

function check_imagenologia(id, empresa, token){
    axios.post('/stevlab/catalogo/checkImagen', {
        _token: token,
        data: id,
    })
    .then(function (response) {
        let estudio = response.data;
        // var t = $('#dataTableEstudios').DataTable();
        // Para settear los estudios
        rellena_tablita(response.data, 'Imagenologia');
    })
    .catch(function (error) {
        console.log(error);
    });
}

function removeThis(obj){
    $(obj).parent().parent().remove();
}