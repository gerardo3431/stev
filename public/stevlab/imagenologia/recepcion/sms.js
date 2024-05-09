function open_modal_sms(obj){
    let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
    $('#modalEstudio').modal('hide');
    $('#modalWhatsapp').modal('show');
    $('#sms_paciente').val('');
    $('#sms_phone_number').val('');
    $('#sms_message').val('');

    let seleccion = $('input:radio[name=radio_membrete]:checked').val();
    
    const respuesta = axios.post('/stevlab/captura/get-paciente-folio-img', {
        folio: folio,
        seleccion: seleccion,
    }).then(function(response){
        console.log(response);
        let message = `Buen día *${response.data.nombre}*.\nLaboratorio *${response.data.laboratorio}* le envia los resultados de sus estudios solicitados. Puede descargarlo en el enlace a continuación o en el mensaje a continuación:\n ${response.data.url} \nExcelente día.\n_-Stevlab_.`;
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

    })
}

// function send_whatsapp(obj){
//     let membrete = 'si';
//     let estudios = [];
//     let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
//     $('#appendComponente').find('.asignEstudio').each(function(key, value){
//         let clave_estudio = $(this).find('.claveEstudio').text().trim();

//         let analitos=[];

//         $(this).find('.listDato').each(function(llave, valor){
//             let id = $(this).find('.idAnalito').val();

//             analitos.push({
//                 id: id,
//             });
//         });
//         estudios.push({
//             clave: clave_estudio,
//             analitos,

//         });
//     });

//     sendsmsajax(membrete, estudios, folio);
// }


// function sendsmsajax(membrete, estudios, folio){
//     const respuesta = axios.post('/stevlab/sms-generate-all-result',{
//         membrete: membrete,
//         folio: folio,
//         estudios: estudios,
//     }).then(function(response){
//         console.log(response);
//         if(response['data']['msj'] == 'success'){
//             const Toast = Swal.mixin({
//                 toast: true,
//                 position: 'top-end',
//                 showConfirmButton: false,
//                 timer: 3000,
//                 timerProgressBar: true,
//             });
            
//             Toast.fire({
//             icon: 'success',
//             title: 'Correo enviado'
//             });

//             // // Reload
//             setTimeout(function(){
//                 window.location.reload();
//             }, 1500);

//         }else if(response['data']['msj'] == 'error'){
//             const Toast = Swal.mixin({
//                 toast: true,
//                 position: 'top-end',
//                 showConfirmButton: false,
//                 timer: 3000,
//                 timerProgressBar: true,
//             });
            
//             Toast.fire({
//             icon: 'error',
//             title: 'Error al enviar correo'
//             });
//         }
//         // window.open(response['data']['pdf']);
//     }).catch(function(error){
//         console.log(error);
//     });
// }

