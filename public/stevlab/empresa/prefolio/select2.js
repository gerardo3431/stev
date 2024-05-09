$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    // axios.post('/stevlab/catalogo/get-lista-precio', {
    //     _token: token,
    //     id_empresa: 1,
    // }).then(function(response){
        
    //     var lista = parse_lista(response.data);
    //     $('#listEstudio').select2('destroy');
    //     $('#listEstudio').empty();
    //     $('#listEstudio').select2({
    //         placeholder: 'Buscar estudios',
    //         data: lista,
    //     });
    // }).catch(function(error){
    //     console.log(error);
    // });
    
    // Lista de estudios
    const estudios = axios.post('/stevlab/catalogo/get-lista-precio', {
        _token: CSRF_TOKEN,
        id_empresa: 1,
    }).then(function(response){
        // console.log(response);
        var lista = parse_lista(response.data);

        $('#listEstudio').select2({
                placeholder: 'Buscar estudios',
                data: lista
        });
        
    }).catch(function(error){
        console.log(error);
    });
    
    $('#listEstudio').on('select2:select', function(e){
        console.log(e.params.data);
        let tipo = e.params.data.tipo;
        let clave   = e.params.data.clave;
        $('#listEstudio').val(null).trigger('change');

        if(tipo == 'Estudio'){
            check_estudio(e.params.data);
        }else if(tipo == 'Perfil'){
            check_perfil(e.params.data);
        }
    });

    var medico = $('#id_doctor').select2({
        placeholder: 'Buscar medicos',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
        ajax:{
            url: '/stevlab/catalogo/getAllMedicos',
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
    var option = new Option('AQC - A QUIEN CORRESPONDA', '1', true, true);
    $('#id_doctor').append(option).trigger('change');
    // Termina funciones de modales
});



function check_estudio(response){
    
    let list =`<tr>
                    <th>${response.clave}</th>
                    <td >${response.descripcion}</td>
                    <td>Estudios</td>
                    <td>
                        <a onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>
                    </td>
                </tr>`;
    $('#tablelistEstudios').append(list);
}

function check_perfil(response){
        let list =`<tr>
                        <th>${response.clave}</th>
                        <td >${response.descripcion}</td>
                        <td>Perfiles</td>
                        <td>
                            <a onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>
                        </td>
                    </tr>`;
    $('#tablelistPerfiles').append(list);
}


// Para retornar todos los estudios bases
function parse_lista(data){
    listEstudios = [];

    if(!jQuery.isEmptyObject(data.estudios)){
        data.estudios.forEach(function(element, index){
            let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - Estudio`, tipo: 'Estudio',clave: element.clave, descripcion:element.descripcion, precio: element.precio};
            listEstudios.push(est_data);
        });
    }
    if(!jQuery.isEmptyObject(data.perfiles)){
        data.perfiles.forEach(function(element, index){
            let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - Perfil`, tipo: 'Perfil',clave: element.clave, descripcion:element.descripcion, precio: element.precio};
            listEstudios.push(est_data);
        });
    }

    if(!jQuery.isEmptyObject(data.lista)){
        // console.log(data.lista);
        data.lista.forEach(function(element, index){
            let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - ${element.tipo}`, tipo: element.tipo ,clave: element.clave, descripcion:element.descripcion, precio: element.precio};
            listEstudios.push(est_data);
        });
    }
    
    // Transforms the top-level key of the response object from 'items' to 'results'
    return listEstudios;
}