function open_modal_sms(obj){
    let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
    $('#modalEstudio').modal('hide');
    $('#modalWhatsapp').modal('show');
    $('#sms_paciente').val('');
    $('#sms_phone_number').val('');
    $('#sms_message').val('');
    let seleccion = $('input:radio[name=radio_membrete]:checked').val();
    
    const respuesta = axios.post('/stevlab/catalogo/get-paciente-folio', {
        folio: folio,
        seleccion: seleccion,
    }).then(function(response){
        console.log(response);
        let message = `Buen día *${response.data.nombre}*.\nLaboratorio *${response.data.laboratorio}* le envia los resultados de sus estudios solicitados. Puede descargarlo en el enlace a continuación o en el mensaje a continuación:\n ${response.data.url} \n\n Cualquier duda o información quedamos a sus órdenes.\n\n_SIEMPRE AL SERVICIO_.`;
        $('#sms_paciente').val(response.data.nombre);
        $('#sms_phone_number').val(response.data.telefono);
        $('#sms_message').val(message);
        
    }).catch(function(error){
        console.log(error);
    });
}

function genera_link(){
    let phone = $('#sms_phone_number').val();
    let message = $('#sms_message').val();
    // event.target[1].value = encodeURI(value)

    const mensaje = axios.post('/stevlab/captura/send-message-link', {
        phone: phone,
        message: encodeURI(message),
    }).then(function(response){
        window.open(response['data']['url']);
        setTimeout(function(){
            window.location.reload();
        }, 1500);
    }).catch(function(error){

    });
}



