function delivery(){
    // $('#modalEstudio').modal('hide');
    $('#modal_delivery').modal('show');
    let valor = $('.folioCaptura').html();

    let folio = $('#folio_archivos');
    let captura = $('#captura_file');
    let img = $('#img_file');
    let captura_maquila = $('#maquila_file');
    let img_maquila = $('#maquila_img');


    captura.prop('disabled', false).prop('checked', false);
    img.prop('disabled', false).prop('checked', false);
    captura_maquila.prop('disabled', false).prop('checked', false);
    img_maquila.prop('disabled', false).prop('checked', false);


    const response = axios.get('/stevlab/recepcion/get-results-preview', {
        params:{
            valor : valor
        }
    }).then(function(respuesta){
        folio.val(respuesta.data.folio);
        
        if(respuesta.data.res_file === null){
            captura.prop('disabled', true);
        }else{
            captura.prop('checked', true);
        }

        if(respuesta.data.res_file_img === null){
            img.prop('disabled', true);
        }else{
            img.prop('checked', true);
        }

        if(respuesta.data.maq_file === null){
            captura_maquila.prop('disabled', true);
        }else{
            captura_maquila.prop('checked', true);
        }
        if(respuesta.data.maq_file_img === null){
            img_maquila.prop('disabled', true);
        }else{
            img_maquila.prop('checked', true);
        }

        // let message = `Buen día *${response.data.nombre}*.\nLaboratorio *${response.data.laboratorio}* le envia los resultados de sus estudios solicitados. Puede descargarlo en el enlace a continuación o en el mensaje a continuación:\n ${response.data.url} \n\n Cualquier duda o información quedamos a sus órdenes.\n\n_SIEMPRE AL SERVICIO_.`;

        console.log(respuesta);
    }).catch(function(error){
        console.log(error);
    });

        
}


function sendingPatient(response){
    let folio = $('.folioCaptura').html();
    let captura = $('#captura_file');
    let img = $('#img_file');
    let maq_captura = $('#maquila_file');
    let maq_img = $('#maquila_img');

    const sending = axios.post('/stevlab/recepcion/preparing-results', {
        folio       : folio,
        captura     : captura.is(':checked'),
        img         : img.is(':checked'),
        maq_captura : maq_captura.is(':checked'),
        maq_img     : maq_img.is(':checked'),
    }).then(function(exito){
        console.log(exito);

        switch (response) {
            case 'correo':
                // console.log('iloveyou');
                // sendingCorreo(folio.val());
                sendajaxmailer(null, null , folio, null);
                break;
            case 'whatsapp':
                let message = `Buen día *${exito.data.nombre_paciente}*.\nLaboratorio *${exito.data.laboratorio}* le envia los resultados de sus estudios solicitados. Puede descargarlo en el enlace a continuación o en el mensaje a continuación:\n ${exito.data.url} \n\n Cualquier duda o información quedamos a sus órdenes.\n\n_SIEMPRE AL SERVICIO_.`;
                modalWhatsapp(message, exito.data.celular_paciente);
                break;
            case 'archivo':
                window.open(exito['data']['pdf']);
                break;
            default:
                window.open(exito['data']['pdf']);
                break;
        }
    }).catch(function(error){
        console.log(error);
    });

}


function modalWhatsapp(mensaje, telefono){
    // send-message-link
    const message = axios.post('/stevlab/captura/send-message-link', {
        phone: telefono,
        message: encodeURI(mensaje),
    }).then(function(response){
        window.open(response['data']['url']);
        // setTimeout(function(){
        //     window.location.reload();
        // }, 1500);
    }).catch(function(error){

    })
}

