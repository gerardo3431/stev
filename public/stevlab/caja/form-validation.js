$(function(){
    'use strict';
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    // Para los valores de referencia de los analitos
    $(function() {
        // validate signup form on keyup and submit
        $("#formCaja").validate({
            rules: {
                cantidad: 'required',
            },
            messages: {
                cantidad: 'Ingrese cantidad a retirar.',
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
                    $(element).addClass( "is-valid" ).removeClass( "is-invalid" );
                }
            },
            submitHandler: function() {
                $.ajax({
                    url: '/stevlab/caja/store-retiro',
                    type: 'POST',
                    data: $('#formCaja').serialize(),
                    success: function(response) {
                        console.log(response);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        
                        Toast.fire({
                        icon: 'success',
                        title: 'Retiro exitoso'
                        });
                        $('#formCaja')[0].reset();
                        $('#modal-retiro-caja').modal('hide');
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(error){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        
                        Toast.fire({
                        icon: 'error',
                        title: 'Reintente por favor'
                        });
                    }            
                });
            }
        });
        // Validar campos de movimientos
        $("#formEgreso").validate({
            rules: {
                tipo_movimiento: {
                    required :true,
                },
                descripcion: {
                    required: true,
                },
                metodo_pago:{
                    required: true,
                },
                importe:{
                    required: true,
                },
                observaciones:{
                    required: false,
                },
                is_factura : false,
            },
            messages: {
                tipo_movimiento: 'Seleccione movimiento.',
                descripcion: 'Agregue una descrición clara.',
                metodo_pago : 'Seleccione método.',
                importe: 'Por favor ingrese importe.',
                observaciones: 'Agregue descripción',
                is_factura: 'Seleccione factura.'
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
                    $(element).addClass( "is-valid" ).removeClass( "is-invalid" );
                }
            },
            submitHandler: function() {
                $('#blockform').prop('disabled', true);

                $.ajax({
                    url: '/stevlab/caja/egreso-caja',
                    type: 'POST',
                    data: $('#formEgreso').serialize(),
                    success: function(response) {
                        console.log(response);
                        if(response == true){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                            
                            Toast.fire({
                            icon: 'success',
                            title: 'Egreso registrado'
                            });
                            $('#formEgreso')[0].reset();
                            
                            setTimeout(function(){
                                window.location.reload();
                            }, 1000);
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
                            title: 'No se pudo agregar el registro, error interno.'
                            });
                        }
                    },
                    error: function(error){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        
                        Toast.fire({
                        icon: 'error',
                        title: 'Reintente por favor'
                        });
                    }            
                });
            }
        });
    });
})    
