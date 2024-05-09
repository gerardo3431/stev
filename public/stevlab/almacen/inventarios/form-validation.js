$(function () {
    "use strict";
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        },
    });
    $(function () {
        // validate signup form on keyup and submit
        $("#addArticulo").validate({
            rules: {
                ubicacion:{
                    required: true
                },
                clave:{
                    required: true,
                    minlength: 3
                },
                articulo:{
                    required: true,
                },
                cantidad:{
                    required: true,
                },
                lote:{
                    required: false,
                },
                caducidad:{
                    required: false,
                },
            },
            messages: {
                ubicacion:{
                    required: "Por favor ingrese area.",
                },
                clave:{
                    required: "Clave es requerido.",
                    minlength: "Ingrese al menos 3 caracteres."
                },
                articulo:{
                    required: "Seleccione articulo."
                },
                cantidad:{
                    required: "Especifique cantidad disponible"
                },
                lote:{
                    required: "Lote requerido"
                },
                caducidad:{
                    required: "Especifique caducidad"
                }
            },
            errorPlacement: function (error, element) {
                error.addClass("invalid-feedback");

                if (element.parent(".input-group").length) {
                    error.insertAfter(element.parent());
                } else if (
                    element.prop("type") === "radio" &&
                    element.parent(".radio-inline").length
                ) {
                    error.insertAfter(element.parent().parent());
                } else if (
                    element.prop("type") === "checkbox" ||
                    element.prop("type") === "radio"
                ) {
                    error.appendTo(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass) {
                if (
                    $(element).prop("type") != "checkbox" &&
                    $(element).prop("type") != "radio"
                ) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                }
            },
            unhighlight: function (element, errorClass) {
                if (
                    $(element).prop("type") != "checkbox" &&
                    $(element).prop("type") != "radio"
                ) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            },
            submitHandler: function() {
                $.ajax({
                    url: '/stevlab/almacen/inventario-store',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        data: $('#addArticulo').serialize(),
                    },
                    // headers: {
                    //     'X-My-Header': 'value'
                    // },
                    // beforeSend: function(xhr) {
                    //     xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                    // },
                    success: function(response) {
                        console.log(response);

                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                            });
                        renderiza();
                        $('#addArticulo')[0].reset();
                        $('#listArticles').append(null).trigger('change');


                    },
                    error: function(xhr, status, error) {
                        // console.log(xhr);
                        // console.log(status);
                        console.log(error);

                        let mensajes = xhr.responseJSON.errors;
                        let lista = $('#errors')
                        
                        mensajes.forEach(element => {
                            lista.append(`<li>${element}</li>`);
                        });

                        $('#notifications').show();
                    }          
                });
            }
        });
        // $.validator.addMethod("alphanumeric", function(value, element) {
        //     return this.optional(element) || /^[\w.]+$/i.test(value);
        // }, "Solo letras y números admitidos.");
    });
});