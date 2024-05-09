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
    const respuesta = axios.post('/stevlab/captura/mailer-generate-imagenologia',{
        membrete: membrete,
        folio: folio,
        estudios: estudios,
        seleccion: seleccion,
    }).then(function(response){
        // console.log(response);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        if(response['data']['response'] == true){
            
            
            Toast.fire({
            icon: 'success',
            title: response.data.msj
            });

            // // Reload
            setTimeout(function(){
                window.location.reload();
            }, 1500);

        }else{
            
            
            Toast.fire({
            icon: 'error',
            title:  response.data.msj
            });
        }
        // window.open(response['data']['pdf']);
    }).catch(function(error){
        console.log(error);
    })
}

function open_modal_correo(obj){
    $('#modalEstudio').modal('hide');
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
    const respuesta = axios.post('/stevlab/captura/mailer-generate-imagenologia',{
        membrete: membrete,
        folio: folio,
        estudios: estudios,
        correo: dato,
        seleccion: seleccion,
    }).then(function(response){
        // console.log(response);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        if(response['data']['response'] == true){
            
            
            Toast.fire({
            icon: 'success',
            title: response.data.msj
            });

            // // Reload
            setTimeout(function(){
                window.location.reload();
            }, 1500);

        }else{
            
            
            Toast.fire({
            icon: 'error',
            title:  response.data.msj
            });
        }
    }).catch(function(error){
        console.log(error);
    });
}
