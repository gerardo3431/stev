'use strict';
var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

$(function(){
    $("#storePatientForm").validate({
        rules: {
            nombre: {
                required: true,
            },
            ap_paterno: {
                required: false,
            },
            ap_materno: {
                required: false,
            },
            sexo:{
                required: true,
            },
            fecha_nacimiento:{
                required: false,
            },
            edad:{
                required: true,
            },
            celular: {
                required: false,
            },
            domicilio: {
                required: false,
            },
            colonia:{
                required: false,
            },
            seguro_popular:{
                required: false,
            },
            vigencia_inicio:{
                required: false,
            },
            vigencia_fin:{
                required: false,
            },
            email:{
                required: false,
            },
            empresa:{
                required: false,
            }
        },
        messages: {
            nombre: {
                required: 'Nombre es requerido.',
            },
            ap_paterno: {
                required: 'Apellido paterno es requerido.',
            },
            ap_materno: {
                required: 'Apellido materno es requerido.',
            },
            sexo:{
                required: 'Establezca sexo por favor.',
            },
            fecha_nacimiento:{
                required: 'Ingrese fecha de nacimiento.'
            },
            celular: {
                required: 'Necesario ingresar número. ',
            },
            domicilio: {
                required: 'Ingrese un domicilio.',
            },
            empresa: {
                required: 'Ingrese una empresa.',
            },
            edad: {
                required: 'Ingrese edad.',
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
            send_paciente_store();
        }
    });

    $('#storeDoctorForm').validate({
        rules: {
            clave:{
                required: true,
                minlength:3,
                remote:{
                    url: "/stevlab/catalogo/verifyKeyDoctor",
                    type:"post",
                    data:{
                        _token: CSRF_TOKEN,
                    }
                },
            },
            nombre:{
                required: true,
            },
            ap_paterno:{
                required: false,
            },
            ap_materno:{
                required: false,
            },
            telefono:{
                required: false,
            },
            celular:{
                required: false,
            },
            email:{
                required: false,
            }
        },
        messages:{
            clave:{
                required: 'Clave es requerido.',
                minlength:  "Debe ingresar al menos 3 caracteres.",
                remote: 'Clave ya ocupada por otro doctor.'
            },
            nombre:{
                required: 'Nombre es requerido.',
            },
            ap_paterno:{
                required: 'Apellido paterno es requerido.',
            },
            ap_materno:{
                required: 'Apellido materno es requerido.',
            },
            telefono:{
                required: 'Télefono es requerido.',
            },
            celular:{
                required: 'Celular es requerido.',
            },
            email:{
                required: 'Correo electronico es requerido.',
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
            send_store_doctor();
            // recepcion();
        }
    });

    $('#formPrefolio').validate({
        rules: {
            id_doctor: {
                required: true,
            },
            id_paciente: {
                required: true,
            },
            observaciones: {
                required: true,
            },
        },
        messages: {
            id_doctor: {
                required: 'Doctor es requerido.',
            },
            id_paciente: {
                required: 'Paciente es requerido.',
            },
            observaciones: {
                required: 'Observaciones es requerido.',
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
            send_prefolio_folio();
        }

    }),
    $('#id_paciente').rules("add", { 
        required: true, 
        messages: { 
            required: "Paciente requerido" 
        } 
    });
    $('#id_doctor').rules("add", { 
        required: true, 
        messages: { 
            required: "Doctor requerido" 
        } 
    });

});

// Paciente
function send_paciente_store(){

    if($('#id_empresa_paciente').val() != ''){
        $.ajax({
            url: '/stevlab/catalogo/paciente-guardar-recepcion',
            type: 'POST',
            data: $('#storePatientForm').serialize(),
            success: function(response) {
                // let dato = JSON.parse(response);

                $('#storePatientForm')[0].reset();
                if(response.mensaje == "Paciente creado con exito"){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                    icon: 'success',
                    title: 'Guardando paciente',
                    });

                    // Paciente
                    $('#id_paciente').empty();
                    var paciente = new Option(response.data.nombre, response.data.id, true, true);
                    $('#id_paciente').append(paciente).trigger('change');
                    // Empresa
                    // $('#id_empresa').empty();
                    // var empresa = new Option(dato.data.nombre_empresa, dato.data.id_empresa, true, true);
                    // $('#id_empresa').append(empresa).trigger('change');

                    // Checa lista
                    // check_empresa(dato.data.id_empresa, CSRF_TOKEN);
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
                    title: 'No se pudo guardar al paciente',
                    });
                }
    
                $('#modal_paciente').modal('hide');
    
            }            
        });
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
        title: 'No puede guardar sin haber asignado empresa',
        });
    }

    
}

// Doctor
function send_store_doctor(){
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $.ajax({
        url: '/stevlab/catalogo/doctor-guardar-recepcion',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            data: $('#storeDoctorForm').serializeArray(),
            lista_precio : $('#lista_precio').val(),
        },
        success: function(response) {

            $('#storeDoctorForm')[0].reset();
            if(response == 'true'){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                icon: 'success',
                title: 'Guardando doctor',
                });
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
                title: 'No se pudo guardar al doctor',
                });
            }

            $('#modal_doctor').modal('hide');

        }            
    });
}
