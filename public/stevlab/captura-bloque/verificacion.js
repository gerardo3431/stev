'use strict';

function verifica_resultados(folio, estudio, analitos ){
    // const respuesta = axios.post('/stevlab/captura/verify-result', {
    //     folio: folio,
    //     identificador :estudio,
    // }).then(function(respon){
    //     console.log(respon);
    //     if(respon.data != ""){
    //         let analitos_resultados = respon.data;
    //         analitos_resultados.forEach(element => {
    //             // console.log(element);
    //             $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.idAnalito').val(element.id);
    //             // $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.ejemploDato').val();
    //             if($('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.ejemploDato').text().trim() == 'Imagen'){
    //                 let url = window.location.origin + '/public/storage/';

    //                 // $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeDato').attr("data-height", 300);
    //                 $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeDato').attr("data-default-file", url + element.valor);

    //                 setTimeout(() => {
    //                     var dropzones = Dropzone.instances;
    //                     for (var i = 0; i < dropzones.length; i++) {
    //                         var dropzoneInstance = dropzones[i];
    //                         var dropzoneElementId = $(dropzoneInstance.element).attr('id');
    //                         // console.log(dropzoneElementId);
    //                         var analitoActual = 'dropzone' +  element.clave;
    //                         // Comparar el ID del elemento Dropzone con el que deseas encontrar
    //                         if (dropzoneElementId === analitoActual) {
    //                             // Ruta relativa del archivo predeterminado dentro de la aplicación
    //                             var defaultFilePath = window.location.origin + '/' + element.valor;
    //                             // Crear objeto File con la ruta relativa
    //                             var defaultFile = { name: defaultFilePath };
    //                             // Agregar archivo predeterminado a la instancia encontrada
    //                             dropzoneInstance.addFile(defaultFile);
    //                             break; // Salir del bucle si se encuentra la instancia específica
    //                         }
    //                     }
    //                 }, 1100);

                    
    //                 // $('.dropify').dropify();
    //             }else{
    //                 $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeDato').val(element.valor);
    //             }

    //             // window.location.origin;
    //             // Para validar on invalidar campos
    //             switch (element.estatus) {
    //                 case 'validado':
    //                     $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeDato').attr('disabled', true);
    //                     $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeAbsolute').attr('disabled', true);
                        
    //                     $('.asignEstudio').find('.guardar'+estudio).attr('disabled', true);
    //                     $('.asignEstudio').find('.validar'+estudio).attr('disabled', true);
    //                     $('.asignEstudio').find('.invalidar'+estudio).attr('disabled', false);
    //                     break;
    //                 case 'invalidado':
    //                     $('.asignEstudio'+estudio).find('.validar'+estudio).attr('disabled', false);
    //                     $('.asignEstudio' +estudio).find('.listDato'+element.clave).find('.edicion').attr('disabled', false);
    //                     break;
    //                 default:
    //                     console.log('Analito entregado?');
    //                     break;
    //             }

    //             // if(element.estatus == 'validado'){
    //             //     // $('.asignEstudio' +estudio ).find('.listDato'+element.clave).find('.edicion').attr('disabled', true);
    //             // }else if(element.estatus == 'invalidado'){
                    
    //             //     // $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.idAnalito').val(element.id);
    //             //     // $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeDato').val(element.valor);
    //             // }

    //             // Para valores absolutos
    //             if(element.absoluto != 0){
    //                 // activeAbsoluto
    //                 $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.activeAbsoluto').prop('checked', true);
    //                 $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.deployValue').show()
    //                 $('.asignEstudio'+estudio).find('.listDato'+element.clave).find('.storeAbsolute').val(element.valor_abs);
    //             }

    //             if(element.entrega == 'entregado'){
    //                 // $('.asignEstudio').find('.invalidar'+estudio).attr('disabled', true);
    //             }
    //         });
    //     }else{
    //         console.log('Sin datos de resultados sobre el estudio');
    //     }
    // }).catch(function(err){
    //     console.log(err);
    // });

    // const response = axios.post('', {
        
    // }).then(element =>{
    //     console.log(element)
    // }).catch(error => {
    //     console.log(error);
    // });
}

function verificaResultados(folio, identificador){
    let foli = folio.trim();
    let identi = identificador.trim();
    const respuesta = axios.post('/stevlab/captura/verify-result', {
        folio: foli,
        identificador: identi,
    }).then(function(respuesta){
        // console.log(respuesta);
        let analitos =respuesta.data;
        analitos.forEach(element => {
            $('.asignEstudio'+identi).find('.listDato'+element.clave).find('.idAnalito').val(element.id);
            $('.asignEstudio' +identi ).find('.listDato'+element.clave).find('.edicion').attr('disabled', true);
        });
        $('.asignEstudio'+identi).find('.listButtons').find('.validar'+identi).attr('disabled', false);


    }).catch(function(err){
        console.log(err);
    });
    
}

function verificaObs(folio, identificador, element){
    let foli = folio.trim();
    let identi = identificador.trim();
    
    $('.asignEstudio'+identi).find('.asignAnalito ').find('.observacion').find('#id_observacion').val(element);
    
}

function insertIntoCkeditor(str){
    // CKEDITOR.instances[ckeditor_id].insertText(str);
}