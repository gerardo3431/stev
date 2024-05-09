$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    const estudios = axios.get('/stevlab/catalogo/get-lista-estudios', {
    }).then(function(response){
        // console.log(response);
        var lista = parse_lista(response.data);

        $('#listEstudio').select2({
                placeholder: 'Buscar estudios',
                data: lista,
        });
        
    }).catch(function(error){
        console.log(error);
    });
    $('#listEstudio').on('select2:select', function(e){
        console.log(e.params.data);
        let tipo = e.params.data.tipo;
        let clave   = e.params.data.clave;
        $('#listEstudio').val(null).trigger('change');

        check_estudio(e.params.data);
        // if(tipo == 'Estudio'){
        // }else if(tipo == 'Perfil'){
        //     check_perfil(e.params.data);
        // }else{
        //     check_imagen(e.params.data);
        // }
    });

    var empresa = $('#id_empresa').select2({
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
    $('#id_empresa').on('select2:select', function(e){
        // console.log(e.params);
        check_empresa(e.params.data.id, CSRF_TOKEN);
    });
    $('#id_empresa').on('select2:unselecting', function(e){
        const estudios = axios.get('/stevlab/catalogo/get-lista-estudios', {
        }).then(function(response){
            // console.log(response);
            var lista = parse_lista(response.data);
            $('#listEstudio').select2('destroy');
            $('#listEstudio').empty();
            $('#listEstudio').select2({
                    placeholder: 'Buscar estudios',
                    data: lista
            });
            
        }).catch(function(error){
            console.log(error);
        });
    });
});


function check_estudio(response){
    
    let list =`<tr>
                    <th>${response.clave}</th>
                    <td >${response.descripcion}</td>
                    <td>${response.tipo}</td>
                    <td>
                        <span>
                        ${response.precio}
                        </span>
                    </td>
                    <td class='text-center'>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1"></label>
                        </div>
                    </td>
                    <td>
                        <a onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>
                    </td>
                </tr>`;
    $('#tablelistEstudios').append(list);
    valuarTotal();
}

// function check_perfil(response){
//         let list =`<tr>
//                         <th>${response.clave}</th>
//                         <td >${response.descripcion}</td>
//                         <td>Perfiles</td>
//                         <td>
//                             <span>
//                             ${response.precio}
//                             </span>
//                         </td>
//                         <td class='text-center'>
//                             <div class="form-check mb-3">
//                                 <input type="checkbox" class="form-check-input" id="exampleCheck1">
//                                 <label class="form-check-label" for="exampleCheck1"></label>
//                             </div>
//                         </td>
//                         <td>
//                             <a onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>
//                         </td>
//                     </tr>`;
//     $('#tablelistPerfiles').append(list);
//     valuarTotal();
// }

// function check_imagen(response){
//             let list =`<tr>
//             <th>${response.clave}</th>
//             <td >${response.descripcion}</td>
//             <td>Imagenologia</td>
//             <td>
//                 <span>
//                 ${response.precio}
//                 </span>
//             </td>
//             <td class='text-center'>
//                 <div class="form-check mb-3">
//                     <input type="checkbox" class="form-check-input" id="exampleCheck1">
//                     <label class="form-check-label" for="exampleCheck1"></label>
//                 </div>
//             </td>
//             <td>
//                 <a onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>
//             </td>
//         </tr>`;
//         $('#tablelistImagenologia').append(list);
//         valuarTotal();
// }


function check_empresa(id, token){
    // console.log(id);
    axios.post('/stevlab/catalogo/get-lista-precio', {
        _token: token,
        id_empresa: id,
    }).then(function(response){
        // console.log(response);
        // var data = $.map(response.data, function (obj) {
        //     obj.id   = obj.id;
        //     obj.text = `${obj.clave} - ${obj.descripcion} - ${obj.tipo}`; // replace name with the property used for the text
        //     return obj;
        // });
        var lista = parse_lista(response.data);
        $('#listEstudio').select2('destroy');
        $('#listEstudio').empty();
        $('#listEstudio').select2({
            placeholder: 'Buscar estudios',
            data: lista,
        });
    }).catch(function(error){
        console.log(error);
    });
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