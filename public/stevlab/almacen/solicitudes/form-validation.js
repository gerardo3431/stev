// addArticulo
$(function () {
    "use strict";

    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        },
    });
    $(function () {
        // validate signup form on keyup and submit
        $("#addSolicitud").validate({
            rules: {
                observaciones:{
                    required: false
                },
                estado:{
                    required: true,
                },
                tipo:{
                    required: true,
                },
            },
            messages: {
                observaciones:{
                    required: "Por favor ingrese observación.",
                },
                estado:{
                    required: "Estado es requerido.",
                },
                tipo:{
                    required: "Tipo debe ser señalado."
                },
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
                makeSolicitud();
            }
        });
        // $.validator.addMethod("alphanumeric", function(value, element) {
        //     return this.optional(element) || /^[\w.]+$/i.test(value);
        // }, "Solo letras y números admitidos.");
    });
});

function checArticles(){
    let articles = [];
    $('#tableListArticles tr').each(function(){
        let tempArticle = {
            clave: $(this).find('td:eq(0)').text(),
            cantidad: $(this).find('td:eq(5)').text(),
            area: $(this).find('td:eq(4)').text(),
        };
        articles.push(tempArticle);
    });
    return articles;
}

function makeSolicitud(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    $('#addRequest').prop('disabled', true);
    $('#showAddRequest').show();

    $.ajax({
        url: '/stevlab/almacen/request-store',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: $('#addSolicitud').serialize(),
            articles : checArticles(),
            folio: $('#folio').val(),
        },
        success: function(response) {
            console.log(response);
            if(response.success == true){
                $('#addSolicitud')[0].reset();
                $('#tableListArticles').empty();
                $('#listArticles').val(null).trigger('change');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message + '. Folio asignado: ' + response.folio
                });
            }

            $('#addRequest').prop('disabled', false);
            $('#showAddRequest').hide();
            $('#addArticulo')[0].reset();
            // $("#addSolicitud").validate().resetForm();

        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);

            let mensajes = xhr.responseJSON.errors;
            if(mensajes){
                let lista = $('#errors')
                
                mensajes.forEach(element => {
                    lista.append(`<li>${element}</li>`);
                });
    
                $('#notifications').show();
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Fallo',
                    text: xhr.responseJSON.message,
                });
            }
            $('#addRequest').prop('disabled', false);
            $('#showAddRequest').hidden();
        }          
    });
}