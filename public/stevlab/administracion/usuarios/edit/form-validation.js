'use strict';
var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

$(function() {
    
    $(function() {
        // validate signup form on keyup and submit
        $("#usuarioForm").validate({
            rules: {
                name:{
                    required: true,
                    minlength: 5,
                },
                email:  {
                    required: 'required',
                    // remote:{
                    //     url: "/stevlab/catalogo/verifyEmail",
                    //     type:"post",
                    //     data:{
                    //         _token: CSRF_TOKEN,
                    //     }
                    // },
                },
                username:  {
                    required: 'required',
                    alphanumeric: true,
                    // remote:{
                    //     url: "/stevlab/catalogo/verifyUsername",
                    //     type:"post",
                    //     data:{
                    //         _token: CSRF_TOKEN,
                    //     }
                    // },
                },
                password:  {
                    required: true,
                    minlength: 8,
                    // strongPassword: true,
                },
                new_password_1:  {
                    required: true,
                    minlength: 8,
                    strongPassword: true,
                    // equalTo: new_password_2,
                },
                new_password_2: {
                    required: true,
                    equalTo: new_password_1,
                },
            },
            messages: {
                name:{
                    required: "Nombre requerido",
                    minlength: "Nombre debe tener mas de 5 letras",
                },
                email:  'Correo requerido',
                username:  {
                    required: 'required',
                    alphanumeric: "Usuario no debe tener simbolos extraños",
                    remote: "Usuario encontrado, por favor asigne nuevo usuario."
                },
                password: {
                    required: "Contraseña requerida",
                    // minlength: "La contraseña debe tener al menos 8 caracteres",
                    // strongPassword: "La contraseña debe contener al menos una letra mayúscula y un número",
                },
                new_password_1: {
                    required: "Confirmar contraseña es requerida",
                    equalTo: "Las contraseñas no coinciden",
                },
                new_password_2: {
                    required: "Confirmar contraseña es requerida",
                    equalTo: "Las contraseñas no coinciden",
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
            
        });
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w.]+$/i.test(value);
        }, "Solo letras y números admitidos.");
        $.validator.addMethod("strongPassword", function(value, element) {
            return this.optional(element) || /^(?=.*[A-Z])(?=.*\d).{8,}$/i.test(value);
        }, "La contraseña debe contener al menos una letra mayúscula, un número y ser mayor a 8 caracteres.");

    });

});