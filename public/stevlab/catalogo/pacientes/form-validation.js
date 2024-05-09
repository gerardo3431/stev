'use strict';

$(function() {
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');


    $('#guardar_dato_empresa').validate({
        rules:{
            clave:{
                required: true,
                minlength: 3,
                remote:{
                    url: "/stevlab/catalogo/verifyKeyEmpresa",
                    type:"post",
                    data:{
                        _token: CSRF_TOKEN,
                    }
                }
            },
            rfc: {
                required: false,
            },
            descripcion:{
                required: true,
            },
            calle:{
                required: false,
            },
            colonia:{
                required: false,
            },
            ciudad:{
                required: false,
            },
            email: {
                required: false,
            },
            telefono:{
                required: false,
            },
            contacto:{
                required: false,
            },
            descuento:{
                required: false,
            }
        },
        messages:{
            clave:{
                required: 'Clave es requerido.',
                minlength: 'Ingrese al menos 3 caracteres.',
                remote: 'Clave en uso.',
            },
            rfc: {
                required: 'RFC  es requerido.',
            },
            descripcion:{
                required: 'Descripcion es requerido.',
            },
            calle:{
                required: 'Calle es requerido.',
            },
            colonia:{
                required: 'Colonia es requerido.',
            },
            ciudad:{
                required: 'Ciudad es requerido.',
            },
            email: {
                required: 'Email es requerido.',
            },
            telefono:{
                required: 'Telefono es requerido.',
            },
            contacto:{
                required: 'Contacto es requerido.',
            },
            descuento:{
                required: 'Descuento es requerido.',
            }
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
            send_empresa_store();
        }
    });


});
// Empresa
function send_empresa_store(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $.ajax({
        url: '/stevlab/catalogo/empresa-guardar-recepcion',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: $('#guardar_dato_empresa').serializeArray(),
        },
        success: function(response) {

            // console.log(response);
            $('#guardar_dato_empresa')[0].reset();
            if(response == 'true'){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                icon: 'success',
                title: 'Guardando empresa',
                });
                $('#modal_nueva_empresa').modal('hide');
            }else{
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                icon: 'error',
                title: 'No se pudo guardar la empresa',
                });
            }


        }            
    });
}