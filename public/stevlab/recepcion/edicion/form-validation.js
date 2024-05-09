'use strict';

$(function() {
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    // validate signup form on keyup and submit
    $("#edit_folio").validate({
        rules: {
            folio:{
                required: false,
            },
            numRegistro:{
                required: true,
            },
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
            comentarios:{
                required: true,
            }
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
            peso:{
                required:"Peso es requerido",
            },
            talla:{
                required:"Talla es requerido",
            },
            medicamento:{
                required:"Medicamento es requerido",
            },
            diagnostico:{
                required:"Diagnostico es requerido",
            },
            observaciones:{
                required:"Observaciones es requerido",
            },
            f_flebotomia:{
                required:"F. flebotomia es requerido",
            },
            num_vuelo:{
                required:"Numero de vuelo es requerido"
            },
            pais_destino:{
                required:"Pais destino es requerido"
            },
            aerolinea:{
                required:"Aerolinea es requerido"
            },
            h_flebotomia:{
                required:"H.Flebotomia es requerido"
            },
            comentarios:{
                required: "Agregue comentarios acerca del motivo de la edición",
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
            // recepcion();
        }
    });

});


function checkEstudios(){
    let lista = [];
    $('#listEstudios tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    $('#listPerfiles tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    $('#listImagenes tr').each(function(){
        lista.push($(this).find('th:eq(0)').text());
    });
    return lista;
}

function checkPerfiles(){
    let perfiles = [];
    $('#listPerfiles tr').each(function(){
        perfiles.push($(this).find('th:eq(0)').text());
    });
    return perfiles;
}

function checkImagenes(){
    let imagenes = [];
    $('#listImagenes tr').each(function(){
        imagenes.push($(this).find('th:eq(0)').text());
    });
    return imagenes;
}


function storeEstudios(identificador){

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    const respuesta = axios.post('/stevlab/recepcion/updateEstudiosFolio', {
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

function sendingAjax(){
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let identificador = $('#identificador').val();

    let lista = [];

    let total = $('#num_total').val().replace(/[$]/g,'');
    $('#guardar_folio').prop('disabled', true);
    $('.search').show();

    $.ajax({
        url: '/stevlab/recepcion/guardar-edit-folio',
        type: 'POST',
        // beforeSend: function(){
        // },
        // data: {
            // _token: CSRF_TOKEN,
            // data: $('#edit_folio').serialize(),
            // lista: checkEstudios(),
            // perfiles:  checkPerfiles(),
            // imagenes: checkImagenes(),
            // total: total,
            // folio: identificador,
        data: $('#edit_folio').serialize(),
        success: function(response) {
            if(response.success === true){

                $('.search').hide();
                let  transform = response;
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
                storeEstudios(transform.data);
                edit_recepcion(transform.data);
            }else{
                Toast.fire({
                    icon: 'success',
                    title: transform.msj,
                });
            }
            // window.location.href = "../editar";
        } ,
        error: function(err){
            $('#guardar_folio').prop('disabled', false);
            $('.search').hide();
            console.log(err);
        }           
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


function edit_recepcion(identificador){
    $('#modal_cobro').modal('show');
    
    let total = $('#num_total').val().replace(/[$]/g,'');
    $('#identificador_folio').val(identificador);
    // $('#total_restante').val(total);
    // $('#solicitud_subtotal').val(total);
    $('#solicitud_descuento').val(0);
    

    const pago = axios.post('/stevlab/caja/calcula-pendiente-pago', {
        identificador: identificador,
    }).then(function(response){
        // console.log(response);
        $('#pago_anterior').val(response.data.monto);
        $('#monto_nuevo').val(total - response.data.pago);

        let monto_actual = total-response.data.monto;
        $('#total_restante').val(monto_actual- response.data.pago);
        $('#solicitud_subtotal').val(monto_actual - response.data.pago);

        // console.log(monto_actual);
    }).catch(function(error){
        console.log(error);
    });
}
