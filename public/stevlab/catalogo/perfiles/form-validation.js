$(function() {
    'use strict';
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
    $(function() {
        // validate signup form on keyup and submit
        $("#regisPerfiles").validate({
            rules: {
                clave:{
                    required: true,
                    alphanumeric:true,
                    minlength: 3,
                    remote:{
                        url: "/stevlab/catalogo/verifyKeyPerfil",
                        type: 'post',
                        data:{
                            _token:CSRF_TOKEN,
                        },
                    },
                },
                descripcion: {
                    required: true,
                },
                precio: 'required',
            },
            messages: {
                clave: {
                    required: 'Por favor ingrese una clave valida.',
                    minlength: 'Debe ingresar al menos 3 caracteres.',
                    remote: 'Clave ya registrada para otro perfil.',
                },
                observaciones: "Por favor ingrese alguna descripcion",
                precio: "Por favor ingrese precio",

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
                send_perfil();
            }
        });
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w.]+$/i.test(value);
        }, "Solo letras y números admitidos.");
    });
});


function recoge_estudios(){
    let lista = [];
    $('#edit_listEstudios tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });

    if(jQuery.isEmptyObject(lista)){
        return null;
    }else{
        return lista;
    }
}

function send_perfil(){
    // Notificacion
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let lista = [];

    $.ajax({
        url: '/stevlab/catalogo/store-perfil',
        type: 'POST',
        data:  $('#regisPerfiles').serialize(),
        success: function(response) {
            if(response.success ){
                Toast.fire({
                    icon: 'success',
                    title: response.mensaje
                });
            }
            console.log(response);
        }            
    });

}