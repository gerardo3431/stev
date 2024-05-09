'use strict';
function guardarEstudios(obj){
    let clave = [];
    let estudio = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identificador = $(obj).parents('.asignEstudio').find('.claveEstudio').text();

    // Guarda analitos
    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        let ejemplo = $(this).find('.ejemploDato').text().trim();

        if(ejemplo == 'Imagen'){
            let prueba = $(this).find('.storeDato')[0].files[0];
        }else if(ejemplo == 'subtitulo'){
            let id = $(this).find('.idAnalito').val();
            let clave = $(this).find('.claveDato').text().trim();
            let descripcion = $(this).find('.descripcionDato').text();
            let valor = $(this).find('.descripcionDato').text();
            
            estudio.push({
                id: id,
                clave: clave,
                descripcion: descripcion,
                valor: valor,
                ejemplo: ejemplo
            });
        }else if(ejemplo == 'Documento'){
            let id = $(this).find('.idAnalito').val();
            let clave = $(this).find('.claveDato').text().trim();
            let descripcion = $(this).find('.descripcionDato').text();
            let valor = $(this).find('.ck-editor__editable').html();
            console.log(valor);
            // text_documento.getData();
            estudio.push({
                id: id,
                clave: clave,
                descripcion: descripcion,
                valor: valor,
                ejemplo: ejemplo
            });
        }else{
            let porcentualBool = '';
            let porcentual = '';

            let id = $(this).find('.idAnalito').val();
            let clave = $(this).find('.claveDato').text();
            let descripcion = $(this).find('.descripcionDato').text();
            let valor = $(this).find('.storeDato').val();

            if($(this).find('.activeAbsoluto').is(':checked') == true){
                porcentualBool = '1';
                porcentual = $(this).find('.activeAbsoluto').parents('.listDato').find('.storeAbsolute').val();
            }else{
                porcentualBool = '0';
                porcentual = null;
            }

            estudio.push({
                id: id,
                clave: clave,
                descripcion: descripcion,
                valor: valor,
                ejemplo: ejemplo,
                porcentualBool: porcentualBool,
                porcentual: porcentual,
            });
        }
    });

    // Guarda estudios
    let observacion = [];
    observacion.push({
        id: $(obj).parents('.asignEstudio').find('.id_observacion').val(),
        observacion : $(obj).parents('.asignEstudio').find('#observaciones_estudio').val(),
    });

    $(obj).prop('disabled', true);
    $(obj).find('.search').show();
    $(obj).find('.saveEstudio').hide();

    // Envia datos
    const response = axios.post('/stevlab/captura/store-resultados-estudios', {
        headers:{
            contentType: false,
            processData: false,
        },
        folio: folio,
        estudio,
        identificador: identificador,
        observacion,
    }).then(function(response){
        console.log(response);
        let dato = response.data.data;
        // verificaResultados(folio, identificador);

        // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        Toast.fire({
        icon: 'success',
        title: 'Resultados guardados correctamente'
        });

        $(obj).prop('disabled', false);
        $(obj).find('.search').hide();
        $(obj).find('.saveEstudio').show();

        // console.log($(obj).parents().find('id_observacion'));
        // $(obj).parents().find('asignEstudio' + identificador).find('id_observacion').val(response.data.observacion);
        // verificaObs(folio, identificador, response.data.observacion);
        // console.log(identificador);
        $('.asignEstudio'+identificador.trim()).find('.listButtons').find('.validar'+identificador.trim()).attr('disabled', false);
        // $(obj).find('.validar'+identificador.trim()).attr('disabled', false);

    }).catch(function(error){
        console.log(error);
        $(obj).prop('disabled', false);
        $(obj).find('.search').hide();
        $(obj).find('.saveEstudio').show();
    });


}

function validarEstudios(obj){
    let estudios = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identificador = $(obj).parents('.asignEstudio').find('.claveEstudio').text();

    
    // Enviar para validar
    const validar = axios.post('/stevlab/captura/validar-estudios', {
        folio : folio,
        identificador: identificador,
    }).then(function(respuesta){
        // console.log(respuesta);
        if(respuesta.data === false){
            // Notificacion
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
            icon: 'error',
            title: respuesta.data.message
            });
            // $(this).find('.storeDato').attr('disabled', true);

            $('.asignEstudio'+identificador.trim()).find('.storeDato').attr('disabled', false);
            $('.asignEstudio'+identificador.trim()).find('.activeAbsoluto').attr('disabled', false);
            $('.asignEstudio'+identificador.trim()).find('.storeAbsolute').attr('disabled', false);


            // console.log($('.asignEstudio'+identificador).find('.storeDato').attr('disabled', false));
            // Para bloquear campos especiales
            
        }else{
            // console.log('gg');
            // Notificacion
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
            icon: 'success',
            title: 'Resultados validados correctamente'
            });

            // Deshabilitar botones
            // asignEstudio 
            $('.asignEstudio'+identificador.trim()).find('.storeDato').attr('disabled', true);
            
            $('.asignEstudio'+identificador.trim()).find('.activeAbsoluto').attr('disabled', true);
            $('.asignEstudio'+identificador.trim()).find('.storeAbsolute').attr('disabled', true);

            $(obj).parents('.listButtons').find('.saveData').attr('disabled', true);
            $(obj).parents('.listButtons').find('.validateData').attr('disabled', true);
            $(obj).parents('.listButtons').find('.invalidateData').attr('disabled', false);

            $(obj).parents('.asignEstudio').find('.listDato').each(function(){
                let ejemplo = $(this).find('.ejemploDato').text().trim();
                if(ejemplo == 'Imagen'){
                    // disabled="disabled" 
                    $(this).find('.dropify').attr('disabled', 'disabled');
                }else if(ejemplo == 'Documento'){
                    console.log(this);
                    $(this).find('.ck-editor__editable').attr('contenteditable', false);
                    // setTimeout(function(){
                        // bloquearEditor(identificador.trim());
                    // }, 1500);
                }
            });

        }

    }).catch(function(error){
        console.log(error);
    });
}

function invalidarEstudios(obj){
    let estudios = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identificador = $(obj).parents('.asignEstudio').find('.claveEstudio').text();


    // $(obj).parents('.asignEstudio').find('.listDato').each(function(){
    //     let id = $(this).find('.idAnalito').val()
    //     let clave = $(this).find('.claveDato').text();
    //     let descripcion = $(this).find('.descripcionDato').text();
    //     let valor = $(this).find('.storeDato').val();
    //     $(this).find('.storeDato').attr('disabled', false);
    //     if($(this).find('.activeAbsoluto').is(':checked') == true){
    //         $(this).find('.activeAbsoluto').parents('.listDato').find('.storeAbsolute').attr('disabled', false); 
    //     }
        
    //     estudios.push({
    //         id: id,
    //         clave: clave,
    //         descripcion: descripcion,
    //         valor: valor,

    //     });
    // });

    // Enviar para invalidar
    const validar = axios.post('/stevlab/captura/invalidar-estudios', {
        folio: folio,
        // estudios,
        identificador
    }).then(function(respuesta){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        if(respuesta.data === false){
            // Deshabilitar botones
            $(obj).parents('.listButtons').find('.saveData').attr('disabled', true);
            $(obj).parents('.listButtons').find('.validateData').attr('disabled', true);
            $(obj).parents('.listButtons').find('.invalidateData').attr('disabled', false);
    
            $('.asignEstudio'+identificador.trim()).find('.storeDato').attr('disabled', true);
            
            $('.asignEstudio'+identificador.trim()).find('.activeAbsoluto').attr('disabled', true);
            $('.asignEstudio'+identificador.trim()).find('.storeAbsolute').attr('disabled', true);

            Toast.fire({
                icon: 'success',
                title: respuesta.response.data.message,
            });
        }else{
            // Deshabilitar botones
            $(obj).parents('.listButtons').find('.saveData').attr('disabled', false);
            $(obj).parents('.listButtons').find('.validateData').attr('disabled', false);
            $(obj).parents('.listButtons').find('.invalidateData').attr('disabled', true);
    
            $('.asignEstudio'+identificador.trim()).find('.storeDato').attr('disabled', false);
            
            $('.asignEstudio'+identificador.trim()).find('.activeAbsoluto').attr('disabled', false);
            $('.asignEstudio'+identificador.trim()).find('.storeAbsolute').attr('disabled', false);
    
            $(obj).parents('.asignEstudio').find('.listDato').each(function(){
                let ejemplo = $(this).find('.ejemploDato').text().trim();
                if(ejemplo == 'Imagen'){
                    // disabled="disabled" 
                    $(this).find('.storeDato').removeAttr('disabled');
    
                }else if(ejemplo == 'Documento'){
                    console.log(this);
                    $(this).find('.ck-editor__editable').attr('contenteditable', true);
                    // setTimeout(function(){
                        // bloquearEditor(identificador.trim());
                    // }, 1500);
                }
    
            });
            Toast.fire({
                icon: 'success',
                title: respuesta.data.message,
            });
        }
        
        
        

        // // Reload
        // setTimeout(function(){
        //     window.location.reload();
        // }, 1500);
        
    }).catch(function(error){
        console.log(error);
    });
}

// Genera pdf normal
function generaPdf(obj){
    let membrete = 'no'
    let estudios = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let clave_estudio = $(obj).parents('.asignEstudio').find('.claveEstudio').text().trim();
    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        let id = $(this).find('.idAnalito').val()
        estudios.push({
            id: id,
        });
    });
    let key='';
    $('.asignEstudio').each(function(){
        key = $(this).find('.folioEstudio').val();
    });

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger me-2",
        },
        buttonsStyling: false,
    });

    swalWithBootstrapButtons
        .fire({
            title: "Impresión?",
            text: "Puedes elegir el formato de impresión",
            icon: "info",
            showCancelButton: true,
            confirmButtonClass: "me-2",
            confirmButtonText: "Si, con membrete!",
            cancelButtonText: "No, sin membrete!",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.value) {
                membrete = 'si';
                make_pdf(estudios, folio, clave_estudio, membrete);
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                membrete = 'no';
                make_pdf(estudios, folio, clave_estudio, membrete);
            }
        });
}

function uploadImagen(obj){

    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    var data = new FormData();
    var file = $(obj)[0].files[0] ;

    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identi = $(obj).parents('.asignEstudio').find('.claveEstudio').text().trim();

    let id = $(obj).parents('.listDato').find('.idAnalito').val();
    let clave = $(obj).parents('.listDato').find('.claveDato').text().trim();
    let descripcion = $(obj).parents('.listDato').find('.descripcionDato').text();
    // let valor = $(this).find('.storeDato').val();
    data.append('_token', CSRF_TOKEN);
    data.append('file', file);
    data.append('folio', folio);
    data.append('id_analito', id);
    data.append('clave', clave);
    data.append('descripcion', descripcion);
    data.append('identificador', identi);


    $.ajax({
        url: '/stevlab/captura/store-imagen-estudios',
        type: 'post',
        data: data,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log($('.asignEstudio'+identi).find('.listDato'+clave).find('.idAnalito').val(response.id));
            $('.asignEstudio'+identi).find('.listDato'+clave).find('.idAnalito').val(response.id);
        }
    });
}