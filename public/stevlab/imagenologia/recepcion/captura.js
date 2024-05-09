'use strict';

function guardarEstudios(obj){
    let estudio = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identificador = $(obj).parents('.asignEstudio').find('.claveEstudio').text();
    
    // Guarda analitos
    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        let ejemplo = $(this).find('.ejemploDato').text().trim();

        // console.log(valor);
        // text_documento.getData();
        if(ejemplo == 'Imagen'){
            let prueba = $(this).find('.storeDato')[0].files[0];
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
            let id = $(this).find('.idAnalito').val();
            let clave = $(this).find('.claveDato').text();
            let descripcion = $(this).find('.descripcionDato').text();
            let valor = $(this).find('.storeDato').val();

            estudio.push({
                id: id,
                clave: clave,
                descripcion: descripcion,
                valor: valor,
                ejemplo: ejemplo
            });
        }
    });

    // Guarda estudios
    let observacion = [];
    observacion.push({
        id: $(obj).parents('.asignEstudio').find('.id_observacion').val(),
        observacion : $(obj).parents('.asignEstudio').find('#observaciones_estudio').val(),
    });

    // Envia datos
    const response = axios.post('/stevlab/captura/store-resultados-imagenologia', {
        headers:{
            contentType: false,
            processData: false,
        },
        folio: folio,
        estudio,
        identificador: identificador,
        observacion,
    }).then(function(response){
        // console.log(response);
        let dato = response.data.data;
        verificaResultados(folio, identificador);

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


    }).catch(function(error){
        console.log(error);
    });


}

function validarEstudios(obj){
    let estudios = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identificador = $(obj).parents('.asignEstudio').find('.claveEstudio').text();

    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        // console.log(obj);
        let id = $(this).find('.idAnalito').val()
        let clave = $(this).find('.claveDato').text();
        let descripcion = $(this).find('.descripcionDato').text();
        let valor = $(this).find('.storeDato').val();
        
        $(this).find('.storeDato').attr('disabled', true);

        estudios.push({
            id: id,
            clave: clave,
            descripcion: descripcion,
            valor: valor,
        });
    });

    
    // Enviar para validar
    const validar = axios.post('/stevlab/captura/validar-estudios-imagenologia', {
        folio : folio,
        estudios,
        identificador: identificador,
    }).then(function(respuesta){
        // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        // console.log(respuesta);
        if(respuesta.data.response == false){
            

            Toast.fire({
            icon: 'error',
            title: respuesta.data.msj,
            });
            // $(this).find('.storeDato').attr('disabled', true);

            $('.asignEstudio'+identificador.trim()).find('.storeDato').attr('disabled', false);
            let miElemento = $('.asignEstudio'+identificador.trim()).find('.storeDato');
            let miDropzone= Dropzone.forElement(miElemento);
            // $('.asignEstudio'+identificador.trim()).dropzone;
            // if(miDropzone){
            //     miDropzone.disable();
            //     $(miDropzone.element).off();
            // }
            // console.log($('.asignEstudio'+identificador).find('.storeDato').attr('disabled', false));
            
        }else{
            // console.log('gg');
            
            
            Toast.fire({
            icon: 'success',
            title: respuesta.data.msj,
            });

            // Deshabilitar botones
            // asignEstudio 
            $(obj).parents('.listButtons').find('.saveData').attr('disabled', true);
            $(obj).parents('.listButtons').find('.validateData').attr('disabled', true);
            $(obj).parents('.listButtons').find('.invalidateData').attr('disabled', false);

        }

    }).catch(function(error){
        console.log(error);
    });
}

function invalidarEstudios(obj){
    let estudios = [];
    let folio = $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    let identificador = $(obj).parents('.asignEstudio').find('.claveEstudio').text();

    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        let id = $(this).find('.idAnalito').val()
        let clave = $(this).find('.claveDato').text();
        let descripcion = $(this).find('.descripcionDato').text();
        let valor = $(this).find('.storeDato').val();
        $(this).find('.storeDato').attr('disabled', false);
        var miDropzone= $(this).find('.storeDato').get(0).dropzone;
        if(miDropzone){
            miDropzone.disable();
            $(miDropzone.element).off();
        }
        
        estudios.push({
            id: id,
            clave: clave,
            descripcion: descripcion,
            valor: valor,

        });
    });

    // Enviar para invalidar
    const validar = axios.post('/stevlab/captura/invalidar-estudios-img', {
        folio: folio,
        estudios,
        identificador
    }).then(function(respuesta){
        console.log(respuesta.data);
        // Deshabilitar botones
        $(obj).parents('.listButtons').find('.saveData').attr('disabled', false);
        $(obj).parents('.listButtons').find('.validateData').attr('disabled', false);
        $(obj).parents('.listButtons').find('.invalidateData').attr('disabled', true);

        // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        if(respuesta.data.success == true){

            Toast.fire({
                icon: 'success',
                title: respuesta.data.message,
            });

            
        }else{
            Toast.fire({
                icon: 'error',
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
        url: '/stevlab/captura/store-zip-estudios',
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