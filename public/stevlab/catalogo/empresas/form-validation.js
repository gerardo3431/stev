$(function() {
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    // validate signup form on keyup and submit
    $("#edit_empresa").validate({
        rules: {
            clave:{
                required: true,
            },
            rfc:{
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
            email:{
                required: false,
            },
            telefono:{
                required: false,
            },
            contacto:{
                required: false,
            },
        },
        messages: {
            clave:{
                required:"Campo es requerido",
            },
            rfc:{
                required:"Campo es requerido",
            },
            descripcion:{
                required:"Campo es requerido",
            },
            calle:{
                required:"Campo es requerido",
            },
            colonia:{
                required:"Campo es requerido",
            },
            ciudad:{
                required:"Campo es requerido",
            },
            email:{
                required:"Campo es requerido",
            },
            telefono:{
                required:"Campo es requerido",
            },
            contacto:{
                required:"Campo es requerido",
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
        },
        submitHandler: function() {
            // stevlab.catalogo.empresa_actualizar
            $.ajax({
                url: '/stevlab/catalogo/empresa_actualizar',
                type: 'POST',
                data: $("#edit_empresa").serializeArray(),
                success: function(response) {
                    console.log(response);
                    if(response.success == true){
                        $('#modalEditar').modal('hide');
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        
                        Toast.fire({
                        icon: 'success',
                        title: response.mensaje
                        });
                        // Reload
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);

                    }
                }            
            });
        }
    });

});