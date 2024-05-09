$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    window.selectedValues = [];

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    // Lista de estudios
    // const estudios = axios.get('/stevlab/catalogo/get-lista-estudios', {
    // }).then(function(response){
    //     // console.log(response);
    //     var lista = parse_lista(response.data);

    //     $('#listEstudio').select2({
    //             placeholder: 'Buscar estudios',
    //             // data: lista
    //     });
        
    // }).catch(function(error){
    //     console.log(error);
    // });

    $('#listEstudio').select2({
            placeholder: 'Buscar estudios',
            // data: lista
    });
    $('#listEstudio').on('select2:select', function(e){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        const selectedValue = e.params.data.clave;
        if (selectedValues.includes(selectedValue)) {
            alert('Este elemento ya fue seleccionado previamente');
            // $(this).val(null).trigger('change'); // Deseleccionar el valor
        } else {

            let tipo = e.params.data.tipo;
            let clave   = e.params.data.clave;
            $('#listEstudio').val(null).trigger('change');

            const verficador = axios.post('/stevlab/catalogo/verifyStudie', {
                _token: CSRF_TOKEN,
                clave: clave
            }).then((response)=>{
                if(response.data.data === true){
                    selectedValues.push(selectedValue); // Agregar el valor al arreglo de selecciones previas

                    Toast.fire({
                        icon: 'success',
                        title: 'Añadiendo',
                    });

                    if(tipo == 'Estudio'){
                        check_estudio(e.params.data);
                    }else if(tipo == 'Perfil'){
                        check_perfil(e.params.data);
                    }else{
                        check_imagenologia(e.params.data);
                    }
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Esta clave no existe en Catalogo. Revise que la clave coincida con su contraparte en Catalogo o actualice la clave.',
                    });
                }

            }).catch((erorr)=>{
                Toast.fire({
                    icon: 'error',
                    title: err.responseJSON.message,
                });
            });
    
            
        }
    });
    $('#listEstudio').on("select2:opening", function(evento){
        if($('#id_empresa').val() != ""){
            return true;
        }else{
            Toast.fire({
                icon: 'info',
                title: 'Busque empresa primero o añada al paciente para que se anexe empresa automáticamente.',
            });
            article.empty().val(null).trigger('change');
            evento.preventDefault();
            return false;
        }
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
    var option = new Option('AQC - A QUIEN CORRESPONDA', '1', true, true);
    $('#id_doctor').append(option).trigger('change');
    
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
                    <td>Estudios</td>
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
    $('#tablelistPerfiles').append(list);
    valuarTotal();
}

function check_imagenologia(response){
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
                            </div>
                        </td>
                        <td>
                            <a onclick="removeThis(this)"><i class="mdi mdi-backspace"></i></a>
                        </td>
                    </tr>`;
    $('#tablelistImagenologia').append(list);
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

    // Para iamgenologia
    if(!jQuery.isEmptyObject(data.imagenologia)){
        data.imagenologia.forEach(function(element, index){
            let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - Imagenologia`, tipo: 'Imagenologia',clave: element.clave, descripcion:element.descripcion, precio: element.precio};
            listEstudios.push(est_data);
        });
    }
    
    // Transforms the top-level key of the response object from 'items' to 'results'
    return listEstudios;
}