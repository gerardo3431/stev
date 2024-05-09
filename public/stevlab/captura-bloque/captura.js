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

        $(obj).prop('disabled', false);
        $(obj).find('.search').hide();
        $(obj).find('.saveEstudio').show();

        // console.log($(obj).parents().find('id_observacion'));
        // $(obj).parents().find('asignEstudio' + identificador).find('id_observacion').val(response.data.observacion);
        verificaObs(folio, identificador, response.data.observacion);

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

    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        // console.log(obj);
        let id = $(this).find('.idAnalito').val()
        let clave = $(this).find('.claveDato').text();
        let descripcion = $(this).find('.descripcionDato').text();
        let valor = $(this).find('.storeDato').val();
        
        $(this).find('.storeDato').attr('disabled', true);
        $(this).find('.storeDato').attr('disabled', true);
        // Valor absoluto si es que lo hay
        if($(this).find('.activeAbsoluto').is(':checked') == true){
            $(this).find('.activeAbsoluto').parents('.listDato').find('.storeAbsolute').attr('disabled', true); 
        }
        // $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeAbsolute')


        estudios.push({
            id: id,
            clave: clave,
            descripcion: descripcion,
            valor: valor,
        });
    });
    
    // Enviar para validar
    const validar = axios.post('/stevlab/captura/validar-estudios', {
        folio : folio,
        estudios,
        identificador: identificador,
    }).then(function(respuesta){
        // console.log(respuesta);
        if(respuesta.data == false){
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
            title: 'Resultados no validados, revise sus permisos o intente guardar de nuevo'
            });
            // $(this).find('.storeDato').attr('disabled', true);

            $('.asignEstudio'+identificador.trim()).find('.storeDato').attr('disabled', false);
            // console.log($('.asignEstudio'+identificador).find('.storeDato').attr('disabled', false));
            
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

    $(obj).parents('.asignEstudio').find('.listDato').each(function(){
        let id = $(this).find('.idAnalito').val()
        let clave = $(this).find('.claveDato').text();
        let descripcion = $(this).find('.descripcionDato').text();
        let valor = $(this).find('.storeDato').val();
        $(this).find('.storeDato').attr('disabled', false);
        if($(this).find('.activeAbsoluto').is(':checked') == true){
            $(this).find('.activeAbsoluto').parents('.listDato').find('.storeAbsolute').attr('disabled', false); 
        }
        
        estudios.push({
            id: id,
            clave: clave,
            descripcion: descripcion,
            valor: valor,

        });
    });

    // Enviar para invalidar
    const validar = axios.post('/stevlab/captura/invalidar-estudios', {
        folio: folio,
        estudios,
    }).then(function(respuesta){
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
        
        Toast.fire({
        icon: 'success',
        title: 'Resultados invalidados',
        });

        // // Reload
        // setTimeout(function(){
        //     window.location.reload();
        // }, 1500);
    }).catch(function(error){
        console.log(error);
    });
}