'use strict';

$(function() {
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    // validate signup form on keyup and submit
    $("#signupForm").validate({
        rules: {
            folio:{
                required: false,
            },
            // numRegistro:{
            //     required: true,
            // },
            id_paciente:{
                required: true,
            },
            id_empresa:{
                required: true,
            },
            fecha_entrega:{
                required: true,
            },
            tipoPaciente:{
                required: true,
            },
            turno:{
                required: true,
            },
            id_doctor:{
                required: true,
            },
            peso:{
                required: false,
            },
            talla:{
                required: false,
            },
            medicamento:{
                required: false,
            },
            diagnostico:{
                required: false,
            },
            observaciones:{
                required: false,
            },
            f_flebotomia:{
                required: false,
            },
            num_total:{
                required:true,
            },
            num_vuelo:{
                required:false,
            },
            pais_destino:{
                required:false,
            },
            aerolinea:{
                required:false,
            },
            numCama:{
                required:false,
            },
            h_flebotomia:{
                required:true,
            },
            check_sangre:{
                required:false,
            },
            check_vih:{
                required:false,
            },
            check_exudado:{
                required:false,
            },
        },
        messages: {
            folio:{
                required:"Folio es requerido",
            },
            numRegistro:{
                required:"Numero de registro es requerido",
            },
            id_paciente:{
                required:"Paciente es requerido",
            },
            id_empresa:{
                required:"Empresa es requerida",
            },
            fecha_entrega:{
                required:"Fecha de entrega   es requerida",
            },
            tipoPaciente:{
                required:"Tipo de paciente es requerido",
            },
            turno:{
                required:"Turno es requerido",
            },
            id_doctor:{
                required:"Doctor es requerido",
            },
            f_flebotomia:{
                required:"F. flebotomia es requerido",
            },
            
            h_flebotomia:{
                required:"H.Flebotomia es requerido"
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
            sendingAjax();
            // recepcion();
        }
    });

    $("#storePatientForm").validate({
        rules: {
            nombre: {
                required: true,
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
            sexo:{
                required: 'Establezca sexo por favor.',
            },
            fecha_nacimiento:{
                required: 'Ingrese fecha de nacimiento.'
            },
            edad:{
                required: "Establezca edad"
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

    $('#storeEmpresaForm').validate({
        rules:{
            clave:{
                required: true,
                minlength: 3,
                remote:{
                    url: "/stevlab/catalogo/verifyKeyEmpresa",
                    type:"post",
                    data:{
                        _token: CSRF_TOKEN,
                    }
                }
            },
            rfc: {
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
            email: {
                required: false,
            },
            telefono:{
                required: false,
            },
            contacto:{
                required: false,
            },
            descuento:{
                required: false,
            }
        },
        messages:{
            clave:{
                required: 'Clave es requerido.',
                minlength: 'Ingrese al menos 3 caracteres.',
                remote: 'Clave en uso.',
            },
            rfc: {
                required: 'RFC  es requerido.',
            },
            descripcion:{
                required: 'Descripcion es requerido.',
            },
            calle:{
                required: 'Calle es requerido.',
            },
            colonia:{
                required: 'Colonia es requerido.',
            },
            ciudad:{
                required: 'Ciudad es requerido.',
            },
            email: {
                required: 'Email es requerido.',
            },
            telefono:{
                required: 'Telefono es requerido.',
            },
            contacto:{
                required: 'Contacto es requerido.',
            },
            descuento:{
                required: 'Descuento es requerido.',
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
            send_empresa_store();
        }
    })
});


function checkEstudios(){
    let lista = [];
    $('#tablelistEstudios tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    $('#tablelistPerfiles tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    $('#tablelistImagenologia tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    return lista;
}

// function checkPerfiles(){
//     let perfiles = [];
//     $('#tablelistPerfiles tr').each(function(){
//         perfiles.push($(this).find('th:eq(0)').text());
//     });
//     return perfiles;
// }

// function checkImagen(){
//     let imagenes = [];
//     $('#tablelistImagenologia tr').each(function(){
//         imagenes.push($(this).find('th:eq(0)').text());
//     });
//     return imagenes;
// }

function sendingAjax(){
    
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let lista = [];

    // Simulo que esta trabajando
    $('#guardar_folio').prop('disabled', true);
    $('.search').show();

    let total = $('#num_total').val().replace(/[$]/g,'');
    $.ajax({
        url: '/stevlab/recepcion/guardar',
        type: 'POST',
        // beforeSend: function(){
        // },
        // data: {
        //     _token: CSRF_TOKEN,
        //     data: $('#signupForm').serialize(),
        //     lista: checkEstudios(),
        //     perfiles:  checkPerfiles(),
        //     imagenes: checkImagen(),
        //     total: total,
        // },
        data:$('#signupForm').serialize(),
        success: function(response) {

            console.log(response);  // revisar 14042023
            
            let  transform = response;


            if(transform.success == true){
                Toast.fire({
                icon: 'success',
                title: transform.msj,
                });

                $('.search').hide();
                storeEstudios(transform.data.id);
                var sangre  = $('#check_sangre').prop('checked');
                var vih     = $('#check_vih').prop('checked');
                var micro   = $('#check_exudado').prop('checked');
                var queryString = '/stevlab/recepcion/formatos-pdf?sangre=' + sangre + '&vih=' + vih + '&micro=' + micro;

                if(sangre !== false || vih !== false || micro !== false){
                    window.open(queryString, '_blank');
                }

                recepcion(transform.data.id);
            }else{
                // Toast.fire({
                // icon: 'error',
                // title: transform.msj,
                // });
            }
        } ,
        error: function(err){
            $('#guardar_folio').prop('disabled', false);
            $('.search').hide();
            console.log(err);
            Toast.fire({
                icon: 'error',
                title: err.responseJSON.message,
            });
        }          
    });
}


function storeEstudios(identificador){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    const respuesta = axios.post('/stevlab/recepcion/guardarEstudios', {
        token: $('meta[name="_token"]').attr('content'),
        id: identificador,
        lista: checkEstudios(),
        // perfiles:  checkPerfiles(),
        // imagenes: checkImagen(),
    }).then((exito)=>{
        console.log(exito);
        Toast.fire({
            icon: 'success',
            title: exito.data.mensaje
        });

        
    }).catch((error)=>{
        console.log(error);
        Toast.fire({
            icon: 'error',
            title: error.responseJSON.message
        });
    });
}
function recepcion(folio){
    $('#modal_cobro').modal('show');
    
    let total = $('#num_total').val().replace(/[$]/g,'');
    $('#identificador_folio').val(folio);
    $('#solicitud_total').val(total);
    $('#solicitud_subtotal').val(total);
    $('#solicitud_descuento').val(0);

}


// Paciente
function send_paciente_store(){
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    if($('#id_empresa_paciente').val() != ''){
        $.ajax({
            url: '/stevlab/catalogo/paciente-guardar-recepcion',
            type: 'POST',
            data: $('#storePatientForm').serialize(),
            success: function(response) {
                let dato = response;

                $('#storePatientForm')[0].reset();
                if(dato.success == true){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                    icon: 'success',
                    title: dato.mensaje,
                    });

                    // Paciente
                    $('#id_paciente').empty();
                    var paciente = new Option(dato.data.nombre, dato.data.id, true, true);
                    $('#id_paciente').append(paciente).trigger('change');
                    // Empresa
                    $('#id_empresa').empty();
                    var empresa = new Option(dato.data.nombre_empresa, dato.data.id_empresa, true, true);
                    $('#id_empresa').append(empresa).trigger('change');

                    // Checa lista
                    check_empresa(dato.data.id_empresa, CSRF_TOKEN);
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
        // data: {
        //     _token: CSRF_TOKEN,
        //     data: $('#storeDoctorForm').serializeArray(),
        //     lista_precio : $('#lista_precio').val(),
        // },
        data: $('#storeDoctorForm').serialize(),
        success: function(response) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            $('#storeDoctorForm')[0].reset();
            if(response.success == true){
                Toast.fire({
                icon: 'success',
                title: response.mensaje
                });
            }else{
                Toast.fire({
                icon: 'error',
                title: 'No se pudo guardar al doctor',
                });
            }

            $('#modal_doctor').modal('hide');

        }            
    });
}

// Empresa
function send_empresa_store(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $.ajax({
        url: '/stevlab/catalogo/empresa-guardar-recepcion',
        type: 'POST',
        data: $('#storeEmpresaForm').serialize(),
        success: function(response) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            $('#storeEmpresaForm')[0].reset();
            if(response.success == 'true'){
                
                Toast.fire({
                icon: 'success',
                title: response.mensaje,
                });
            }else{
                
                Toast.fire({
                icon: 'error',
                title: 'No se pudo guardar la empresa',
                });
            }

            $('#modal_empresa').modal('hide');

        }            
    });
}
