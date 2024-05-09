'use strict';

$(function() {
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    
    $("#formPrefolio").validate({
        rules: {
            nombre:{
                required: true,
            },
            observaciones:{
                required: false,
            },
            documento:{
                required: false,
            },
            file: {
                required: false,
                extension: "jpg|jpeg|rar|zip|docx|pdf",
                // extension: "mp3|mpeg|mp4"
            }
        },
        messages: {
            folio:{
                required:"Campo nombre es requerido.",
            },
            observaciones:{
                required:"Observaciones es requerido.",
            },
            documento: {
                required: "Datos de referencias es requerido."
            },
            file:{
                required: "Archivos no subido.",
                extension: "Cargue archivos con las extensiones permitidas."
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
            sendingAjax();
        }
    });

    // // validate signup form on keyup and submit
    // $.validator.addMethod("validateFile", function(value, element) {
    //     var fileExtension = ['mp3', 'mpeg', 'mp4'];
    //     return ($.inArray(value.split('.').pop().toLowerCase(), fileExtension) != -1)
    // }, "Please select a valid file(MP3, MPEG and MP4 are allowed)");

});



function checkEstudios(){
    let lista = [];
    $('#tablelistEstudios tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    return lista;
}

function checkPerfiles(){
    let perfiles = [];
    $('#tablelistPerfiles tr').each(function(){
        perfiles.push($(this).find('th:eq(0)').text());
    });
    return perfiles;
}

function form_data(){
    // let formulario = $('#formPrefolio')[0];
    // datos.append('_token', CSRF_TOKEN);
    // datos.append('nombre', $('#nombre').val());
    // datos.append('observaciones', $('#observaciones').val());
    let datos = new FormData();
    datos.append('file', $('#file').prop("files")[0], $('#file').prop("files")[0].name);
    return datos;
}

function sendingAjax(){
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let lista = checkEstudios();
    let perfiles = checkPerfiles();
    let datos = new FormData($('#formPrefolio')[0]);

    $('#store_prefolio').prop('disabled', true);
    
        $.ajax({
            url: '/stevlab/empresa/store-prefolio',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                // data: new FormData($('#formPrefolio')[0]),
                data: $('#formPrefolio').serializeArray(),
                // data: datos,
                // file: archivo,
                lista: checkEstudios(),
                perfiles:  checkPerfiles(),
            },
            success: function(response) {
                console.log(response);
                let  data = JSON.parse(response);
                if(data.response == true){
                    // send_file(data.id);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                    icon: 'success',
                    title: 'Guardando registro...',
                    });
            
                    window.open(data['pdf']['prefolio']);

                    $('#targetImagen').modal('show');
                    $('#identificador').val(data.id);
                    // setTimeout(function(){
                    //     window.location.reload();
                    // }, 1000);
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
                    title: 'Prefolio no pudo ser procesado...',
                    });
    
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }
            }            
        }).fail(function(error){
            console.log(error);
        });
}