$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    // Lista de estudios
    const estudios = axios.get('/stevlab/catalogo/get-lista-estudios', {
    }).then(function(response){
        // console.log(response);
        var lista = parse_lista(response.data);
        let prueba = $('#id_empresa').val();
        // $("#id_empresa").prop("disabled", true);
        $("#id_paciente").prop("disabled", true);

        $('#listEstudio').select2({
                placeholder: 'Buscar estudios',
                data: lista
        });
        check_empresa(prueba, CSRF_TOKEN);

        
    }).catch(function(error){
        console.log(error);
    });
    $('#listEstudio').on('select2:select', function(e){
        console.log(e.params.data);
        let tipo = e.params.data.tipo;
        let clave   = e.params.data.clave;
        $('#listEstudio').val(null).trigger('change');

        check_estudio(e.params.data);
    });

    
    var paciente = $('#id_paciente').select2({
        placeholder: 'Buscar pacientes',
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
        let paciente = $('#id_paciente').val()[0];

        check_paciente(paciente, CSRF_TOKEN);
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

    // Para los modales
    var medico = $('#id_doctor').select2({
        placeholder: 'Buscar medicos',
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

    var precio = $('#lista_precio').select2({
        dropdownParent: $('#modal_empresa'),
		placeholder: 'Buscar estudios',
        maximumSelectionLength: 1,
        minimumInputLength: 3,
		placeholder: 'Busca lista de precio',
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
    // Termina funciones de modales
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
    $('#listEstudios').append(list);
    valuarTotal();
}

function check_perfil(response){
        let list =`<tr>
                        <th>${response.clave}</th>
                        <td >${response.descripcion}</td>
                        <td>Perfiles</td>
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
    $('#listPerfiles').append(list);
    valuarTotal();
}

function check_imagen(response){
    let list =`<tr>
        <th>${response.clave}</th>
        <td >${response.descripcion}</td>
        <td>Imagenologia</td>
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
    $('#listImagenes').append(list);
    valuarTotal();
}


function check_paciente(id, token){
    axios.post('/stevlab/catalogo/get_empresa_paciente', {
        _token: token,
        id_paciente: id,
    }).then(function(response){
        // console.log(response);
        let identificador = '';
        let empresa = response.data;
        if(empresa){
            $('#id_empresa').empty();
            var option = new Option(empresa.descripcion, empresa.id, true, true);
            $('#id_empresa').append(option).trigger('change');
            identificador = empresa.id;
        }else{
            $('#id_empresa').empty();
            var option = new Option('PARTICULAR', '1', true, true);
            $('#id_empresa').append(option).trigger('change');
            identificador = 1;
        }

        check_empresa(identificador, token);
    }).catch(function(error){
        console.log(error);
    });
}

function check_empresa(id, token){
    // console.log(id);
    axios.post('/stevlab/catalogo/get-lista-precio', {
        _token: token,
        id_empresa: id,
    }).then(function(response){
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