function send_email(obj){
    let membrete = 'si';
    let estudios = [];
    let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
    let seleccion = $('input:radio[name=radio_membrete]:checked').val();

    $('#appendComponente').find('.asignEstudio').each(function(key, value){
        let clave_estudio = $(this).find('.claveEstudio').text().trim();

        let analitos=[];

        $(this).find('.listDato').each(function(llave, valor){
            let id = $(this).find('.idAnalito').val();

            analitos.push({
                id: id,
            });
        });
        estudios.push({
            clave: clave_estudio,
            analitos,

        });
    });

    sendajaxmailer(membrete, estudios, folio, seleccion);
}


function sendajaxmailer(membrete, estudios, folio, seleccion){
    const respuesta = axios.post('/stevlab/captura/mailer-generate-all-result',{
        membrete: membrete,
        folio: folio,
        estudios: estudios,
        seleccion: seleccion,
    }).then(function(response){
        console.log(response);
        if(response['data']['msj']){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
            icon: 'info',
            title: response['data']['msj']
            });

            // // // Reload
            // setTimeout(function(){
            //     window.location.reload();
            // }, 1500);

        }else{
            
        }
        // window.open(response['data']['pdf']);
    }).catch(function(error){
        console.log(error);
    });
}

function open_modal_correo(obj){
    $('#modalEstudio').modal('hide');

    $('.folioCaptura').html();
    let mensaje = axios.post('/stevlab/captura/obtainMails', {
        folio: $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val()
    }).then((response)=>{
        console.log(response);
        $('#correo_doctor').val(response.data.data.correo_doctor);
        $('#correo_empresa').val(response.data.data.correo_empresa);
        $('#correo_paciente').val(response.data.data.correo_patient);
    }).catch((error)=>{
        console.log(error);
    });
    $('#modal_correo').modal('show');
}



function genera_correo(){
    let dato = $('#correo_form').serializeArray();

    let membrete = 'si';
    let estudios = [];
    let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
    let seleccion = $('input:radio[name=radio_membrete]:checked').val();

    $('#appendComponente').find('.asignEstudio').each(function(key, value){
        let clave_estudio = $(this).find('.claveEstudio').text().trim();

        let analitos=[];

        $(this).find('.listDato').each(function(llave, valor){
            let id = $(this).find('.idAnalito').val();

            analitos.push({
                id: id,
            });
        });
        estudios.push({
            clave: clave_estudio,
            analitos,

        });
    });

    send_correo_multiple(membrete, estudios, folio, dato, seleccion);

    
}

function send_correo_multiple(membrete, estudios, folio, dato, seleccion){
    
    const respuesta = axios.post('/stevlab/captura/correo-send-multiple',{
        membrete: membrete,
        folio: folio,
        estudios: estudios,
        correo: dato,
        seleccion: seleccion,
    }).then(function(response){
        console.log(response);
        if(response['data']['msj']){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
            icon: 'info',
            title: response['data']['msj']
            });

            // // Reload
            // setTimeout(function(){
            //     window.location.reload();
            // }, 1500);

        }
        // window.open(response['data']['pdf']);
    }).catch(function(error){
        console.log(error);
    });
}
