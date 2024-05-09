$(function() {
    'use strict';
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    $(function() {
        // validate signup form on keyup and submit
        $("#regisUser").validate({
            rules: {
                name:{
                    required: true,
                    minlength: 5,
                },
                email:  'required',
                username:  {
                    required: 'required',
                    alphanumeric: true,
                },
                password:  {
                    required: true,
                    minlength: 8,
                    strongPassword: true,
                },
                confirmar_contraseña: {
                    required: true,
                    equalTo: password,
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
                },
                password: {
                    required: "Contraseña requerida",
                    minlength: "La contraseña debe tener al menos 8 caracteres",
                    strongPassword: "La contraseña debe contener al menos una letra mayúscula y un número",
                },
                confirmar_contraseña: {
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
            submitHandler: function() {
                $.ajax({
                    url: '/stevlab/administracion/store-user',
                    type: 'POST',
                    data: $('#regisUser').serialize(),
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
                        
                        Toast.fire({
                        icon: 'success',
                        title: 'Usuario guardado correctamente'
                        });

                        // Reload
                        // setTimeout(function(){
                        //     window.location.reload();
                        // }, 3100);
                        $('#regisUser')[0].reset();
                        $('#modalUsuario').modal('hide');
    
                    }  ,
                    error: function(xhr, status, error) {
                        // console.log(xhr);
                        // console.log(status);
                        // console.log(error);

                        alert(xhr.responseText)
                        // Aquí puedes manejar el error como desees, mostrar un mensaje de error, etc.
                    }
                });
            }
        });
        $.validator.addMethod("alphanumeric", function(value, element) {
            return this.optional(element) || /^[\w.]+$/i.test(value);
        }, "Solo letras y números admitidos.");
        $.validator.addMethod("strongPassword", function(value, element) {
            return this.optional(element) || /^(?=.*[A-Z])(?=.*\d).{8,}$/i.test(value);
        }, "La contraseña debe contener al menos una letra mayúscula, un número y ser mayor a 8 caracteres.");

    });

});