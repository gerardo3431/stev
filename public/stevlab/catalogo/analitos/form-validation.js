$(function() {
    'use strict';
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        // validate signup form on keyup and submit
        $("#regisAnalito").validate({
            rules: {
                clave:{
                    required: true,
                    minlength:3,
                    remote:{
                        url: "/stevlab/catalogo/verifyKeyAnalito",
                        type:"post",
                        data:{
                            _token: CSRF_TOKEN,
                        }
                    },
                    alphanumeric: true,
                },
                descripcion:  'required',
            },
            messages: {
                clave: {
                    required:   "Ingrese clave.",
                    minlength:  "Debe ingresar al menos 3 caracteres.",
                    remote:     "Clave ya registrada para otro analito.",
                },
                descripcion:    'Ingrese descripción.',
                
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
            submitHandler: function() {
                $.ajax({
                    url: '/stevlab/catalogo/store-analito',
                    type: 'POST',
                    data: $('#regisAnalito').serialize(),
                    success: function(response) {
                        console.log(response);
                         // Notificacion
                        let  value = `<input type="hidden" id='analito' name="analito" value="${response.id}">`;

                        Toast.fire({
                            icon: 'success',
                            title: response.mensaje
                        });
    
                        $('#modalAnalito').modal('hide');

                        switch (response.tipo_resultado) {
                            case 'referencia':
                                    $('#modalReferencia').modal('show');
                                    $('#referenciaAnalito').append(value);
                                break;
                            case 'imagen':
                                    $('#targetImagen').modal('show');
                                    $('#formImagen').prepend(value);
                                break;
                            default:
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 3100);
                                break;
                        }
    
                    },
                    error: function(error){
                        console.log(error);
                        Toast.fire({
                            icon: 'success',
                            title: error
                        });
                    }           
                });
            }
        });
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w.]+$/i.test(value);
        }, "Solo letras y números admitidos.");
    });

    // Para los valores de referencia de los analitos
    $(function() {
        // validate signup form on keyup and submit
        $("#referenciaAnalito").validate({
            rules: {
                edad_inicial: 'required',
                tipo_inicial: 'required',
                edad_final: 'required',
                tipo_final: 'required',
                sexo:{
                    required: true,
                },
                referencia_inicial:'required',
                referencia_final:'required',
            },
            messages: {
                edad_inicial: 'Ingrese edad inicial de referencia.',
                tipo_inicial: 'Seleccione tipo.',
                edad_final: 'Ingrese edad final de referencia.',
                tipo_final: 'Seleccione tipo.',
                sexo: 'Seleccione sexo.',
                referencia_inicial: 'Ingrese valor de referencia inicial.',
                referencia_final: 'Ingrese valor de referencia final.',
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
                    $(element).addClass( "is-valid" ).removeClass( "is-invalid" );
                }
            },
            submitHandler: function() {
                $.ajax({
                    url: '/stevlab/catalogo/store-referencia',
                    type: 'POST',
                    data: $('#referenciaAnalito').serialize(),
                    success: function(response) {
                        console.log(response);
                        let data = `
                                    <tr>
                                        <th class='text-center'>${response.edad_inicial}</th>
                                        <th class='text-center'>${response.tipo_inicial}</th>
                                        <th class='text-center'>${response.edad_final}</th>
                                        <th class='text-center'>${response.tipo_final}</th>
                                        <th class='text-center'>${response.sexo}</th>
                                        <th class='text-center'>${response.referencia_inicial}</th>
                                        <th class='text-center'>${response.referencia_final}</th>
                                        <th class='text-center'>${response.dias_inicio}</th>
                                        <th class='text-center'>${response.dias_final}</th>
                                        <th class='d-flex align-items-center'>
                                            <button  onclick='removeReferences(this, ${response.id})' type="button" class="btn btn-xs btn-danger btn-icon delete">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </th>
                                    </tr>
                                `;
                        $('#valoresReferencias').append(data);
                    }            
                });
            }
        });
    });
});
