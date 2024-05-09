'use strict';

function removeEstudio(obj){
    $(obj).parent().parent().remove();
}

function editarPerfil(obj){
    $('#editarModal').modal('show');

    validar_formulario();
    
    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();
    
    const pregunta = axios.post('/stevlab/catalogo/getPerfilesEstudios', {
        clave: clave, 
    }).then(function(response){
        let perfil = response.data;
        // let estudios = response.data.estudios;
        $('#identificador').val(perfil.id);
        $('#edit_clave').val(perfil.clave);

        $('#edit_clave').attr('disabled', true);
        $('#edit_codigo').val(perfil.codigo);
        $('#edit_descripcion').val(perfil.descripcion);
        $('#edit_observaciones').val(perfil.observaciones);
        $('#edit_precio').val(perfil.precio);
        
    }).catch(function(error){
        console.log(error);
    });
}

function select2_modal(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    
    var edit_estudio = $("#edit_estudio").select2({
        dropdownParent: $('#asignarModal'),
        placeholder: 'Buscar estudio',
        maximumSelectionLength: 1,
        ajax: {
            url: 'getEstudios',
            type: 'get',
            delay: '200',
            data: function(params){
                return{
                    _token: CSRF_TOKEN,
                    q: params.term,
                }
            },
            processResults: function (data) {
                var listEstudios = [];
                data.forEach(function(element, index){
                    let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion}`};
                    listEstudios.push(est_data);
                });
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: listEstudios
                };
            }
        }
    });
    $('#edit_estudio').on('select2:select', function (e) {
        $('#edit_estudio').val(null).trigger('change');
        
        let data= e.params.data.id;
        // Revisame los analitos que ya esten asignados
        axios.post('/stevlab/catalogo/checkEstudio', {
            _token: CSRF_TOKEN,
            data: data,
            
        })
        .then(function (response) {
            let list = "";
            // Para settear los estudios
            list =`	<tr>
                            <th style='white-space:pre-wrap'>${response.data.clave}</th>
                            <td style='white-space:pre-wrap' >${response.data.descripcion}</td>
                            <td style='white-space:pre-wrap'>${response.data.condiciones}</td>
                            <td style='white-space:pre-wrap'>
                                <a onclick='removeEstudio(this)' href="#"><i class="mdi mdi-backspace"></i></a>
                            </td>
                        </tr>`;
            console.log(list);

            $('#edit_listEstudios').append(list);
        })
        .catch(function (error) {
            console.log(error);
        });
    });
}

function removeEstudioReal(obj){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    let clave = $(obj).parent().parent().find('th:eq(0)').text();

    let identificador = $('#identificador').val();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-2'
        },
        buttonsStyling: false,
    })
    
    swalWithBootstrapButtons.fire({
        title: '¿Estas seguro?',
        text: "Esta acción es permanente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'me-2',
        confirmButtonText: 'Si, eliminalo!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            const respuesta = axios.post('/stevlab/catalogo/eliminar-estudio-perfil',{
                _token: CSRF_TOKEN,
                clave:clave,
                perfil: identificador,
            }).then(function(response){
                swalWithBootstrapButtons.fire(
                    'Borrado!',
                    response.data.mensaje,
                    'success'
                    );
                $(obj).parent().parent().remove();

            })
            .catch(function(error){
                console.log(error);
            });
        } else if (
            // Read more about handling dismissals
            result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El estudio no fue eliminado.',
                    'error'
                    )
                }
    });
}

function validar_formulario(){

    $("#edit_regisPerfiles").validate({
        rules: {
            clave:{
                required: true,
                minlength: 3,
                alphanumeric: true,
            },
            descripcion: {
                required: true,
            },
        },
        messages: {
            clave: {
                required: 'Por favor ingrese una clave valida.',
                minlength: 'Debe ingresar al menos 3 caracteres.',
            },
            observaciones: "Por favor ingrese alguna descripcion",
        },
        errorPlacement: function(error, element) {
            error.addClass( "invalid-feedback" );
            
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            }
        },
        unhighlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        },
        submitHandler: function(){
            send_edit_estudios_perfil();
        }
    });
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[\w.]+$/i.test(value);
    }, "Solo letras y números admitidos.");
}

function recoge_edit_estudios(){

    let lista = [];

    $('#edit_listEstudios tr').each(function(){
        // precio = precio + parseFloat($(this).find('td:eq(2)').text());
        // console.log($(this).find('td:eq(2)').text());
        lista.push($(this).find('th:eq(0)').text());
    });
    if(jQuery.isEmptyObject(lista)){
        return null;
    }else{
        return lista;
    }
}

function send_edit_estudios_perfil(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let lista = [];

    $.ajax({
        url: '/stevlab/catalogo/update-perfil',
        type: 'POST',
        // beforeSend: function(){
        // },
        data: $('#edit_regisPerfiles').serializeArray(),
        success: function(response) {
            console.log(response);
            // Notificacion
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            if(response.success === true){
                Toast.fire({
                icon: 'success',
                title: response.mensaje
                });
                // Reload
                setTimeout(function(){
                    window.location.reload();
                }, 2900);
            }
            
        }            
    });

}


function asignarEstudios(identificador){
    $('#edit_listEstudios').empty();

    $('#asignarModal').modal('show');

    $('#identificador').val(identificador);

    select2_modal();


    var idPerfil = identificador;
    axios.post('/stevlab/catalogo/getEstudiosPerfiles' ,{
        id : idPerfil,
    }).then((exito)=>{
        console.log(exito);
        let componente = listado(exito.data);
        $('#edit_listEstudios').append(componente);

    }).catch((error)=>{
        console.log(error);
    });
}


function listado(data){
    let resultado = "";
    
    data.forEach(element => {
        resultado +=`
            <tr>
                <th style='white-space:pre-wrap'>${element.clave}</th>
                <td  style='white-space:pre-wrap'>${element.descripcion}</td>
                <td style='white-space:pre-wrap'>${element.condiciones}</td>
                <td style='white-space:pre-wrap'>
                    <a onclick='removeEstudioReal(this)' href="#"><i class="mdi mdi-backspace"></i></a>
                </td>
            </tr>`;
    });

    return resultado;
}


function guardarEstudios(){
    
    let identificador = $('#identificador').val();
    let lista = recoge_estudios();

    //  Notificacion
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    let mensaje = axios.post('/stevlab/catalogo/associate-studies', {
        id   : identificador,
        data : lista,
    }).then((exito)=>{
        Toast.fire({
            icon: 'success',
            title: exito.data.mensaje
        });
        console.log(exito);
        $('#asignarModal').modal('hide');
    }).catch((error)=>{
        Toast.fire({
            icon: 'error',
            title: 'No se pudo guardar la lista'
        });
        console.log(error);
    })
}