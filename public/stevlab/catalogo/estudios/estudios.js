$(function() {
    'use strict';
    
    $.validator.setDefaults({
        submitHandler: function() {
            console.log("submitted!");
        }
    });
    $(function() {
        // validate signup form on keyup and submit
        $("#registro_estudios").validate({
            rules: {
                clave: {
                    required: true,
                    minlength: 4,
                    remote:{
                        url: "/stevlab/catalogo/verifyKeyEstudio",
                        type: 'post',
                        data:{
                            _token:CSRF_TOKEN,
                        },
                        alphanumeric: true,
                    }
                },
                descripcion: {
                    required: true,
                    minlength: 8
                },
            },
            messages: {
                clave:{
                    required: "Por favor ingrese clave.",
                    minlength: "Clave debe tener 4 carácteres mínimo."
                },
                descripcion:{
                    required: "Por favor ingrese descripción.",
                    minlength:"Texto debe tener 8 carácteres minímo"
                },
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
            }
        });
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w.]+$/i.test(value);
        }, "Solo letras y números admitidos.");
    });
});