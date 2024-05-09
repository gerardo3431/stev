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

    
    $(function () {
        // validate signup form on keyup and submit
        $("#edit_imagenologia").validate({
            rules: {
                edit_clave:{
                    required: true,
                    minlength: 3,
                    // remote:{
                    //     url: "/stevlab/catalogo/verifyKeyPicture",
                    //     type:"post",
                    //     data:{
                    //         _token: CSRF_TOKEN,
                    //     }
                    // },
                },
                edit_codigo:{
                    required: true,
                },
                edit_descripcion:{
                    required: true,
                },
                edit_area:{
                    required: true,
                },
                edit_condiciones:{
                    required: true,
                },
                edit_precio:{
                    required: true,
                }
            },
            messages: {
                edit_clave:{
                    required: "Campo es requerido",
                    minlength: "Minimo 3 caracteres",
                    // remote: "Clave existente"
                },
                edit_codigo:{
                    required: "Campo es requerido",
                },
                edit_descripcion:{
                    required: "Campo es requerido",
                },
                edit_area:{
                    required: "Campo es requerido",
                },
                edit_condiciones:{
                    required: "Campo es requerido",
                },
                edit_precio:{
                    required: "Campo es requerido",
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
                    url: '/stevlab/catalogo/update-imagenologia',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN,
                        data: $('#edit_imagenologia').serialize(),
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
                        $('#edit_imagenologia')[0].reset();
                        $('#modalPicture').modal('hide');

                        setTimeout(function(){
                            window.location.reload();
                        }, 2900);

                    },
                    error: function(xhr, status, error) {
                        // console.log(xhr);
                        // console.log(status);
                        console.log(error);

                        // $('#notifications').show();
                    }          
                });
            }
        });
        // $.validator.addMethod("alphanumeric", function(value, element) {
        //     return this.optional(element) || /^[\w.]+$/i.test(value);
        // }, "Solo letras y números admitidos.");
    });
});