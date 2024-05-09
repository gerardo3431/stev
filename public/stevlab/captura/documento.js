'use strict';

// function para enviar ajax a la generacion de documento
function make_pdf(estudios, folio, clave_estudio, membrete){
    let seleccion = $('input:radio[name=radio_membrete]:checked').val();
    let estilo = $('input:radio[name=salto_hoja]:checked').val();

    var verifica = '';
    const documento = axios.post('/stevlab/captura/genera-documento-resultados',{
        estudios,
        folio: folio,
        clave: clave_estudio,
        membrete: membrete,
        seleccion: seleccion,
        estilo: estilo
    }).then(function(response){
        console.log(response);
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
        title: 'Generando pdf... Espere por favor',
        });
        window.open(response['data']['pdf']);
        // $('.asignEstudio').find('.invalidar'+estudio).attr('disabled', true);
        // $('.listButtons').find('.invalidateData').attr('disabled', true);

    }).catch(function(error){
        // Notificacion
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se puede generar documento, verifique que los resultados esten validados.',
        });
        console.log(error);
    });
    
    
}



// FUNCION PARA GENERAR LOS RESULTADOS COMPLETOS
function pdf_all() {
    let membrete = "";
    let estudios = [];
    let folio = $("#appendComponente")
        .find(".asignEstudio")
        .find(".folioEstudio")
        .val();
    let seleccion = $("input:radio[name=radio_membrete]:checked").val();
    let estilo = $('input:radio[name=salto_hoja]:checked').val();

    $("#appendComponente").find(".asignEstudio").each(function (key, value) {
            let clave_estudio = $(this).find(".claveEstudio").text().trim();

            let analitos = [];

            $(this).find(".listDato").each(function (llave, valor) {
                    let id = $(this).find(".idAnalito").val();

                    analitos.push({
                        id: id,
                    });
                });

            estudios.push({
                clave: clave_estudio,
                analitos,
            });
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
                sendajax(membrete, estudios, folio, seleccion, estilo);
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                membrete = 'no';
                sendajax(membrete, estudios, folio, seleccion, estilo);
            }
        });
}

// function pdf_all_membrete(obj){
//     let membrete = 'si';
//     let estudios = [];
//     let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
//     let seleccion = $('input:radio[name=radio_membrete]:checked').val();
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

//     sendajax(membrete, estudios, folio, seleccion);
    
// }

function sendajax(membrete, estudios, folio, seleccion, estilo){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    var verifica = '';
    const respuesta = axios.post('/stevlab/captura/generate-all-result',{
        membrete: membrete,
        folio: folio,
        estudios: estudios,
        seleccion: seleccion,
        estilo: estilo
    }).then(function(response){
        console.log(response);

        // if(response.data.message){
        //     Toast.fire({
        //         icon: 'error',
        //         title: response.data.message
        //     });
        // }
        
        Toast.fire({
        icon: 'success',
        title: 'Generando documento'
        });

        window.open('/public/storage/' + response['data']['pdf']);

    }).catch(function(error){
        console.log(error);

        Toast.fire({
            icon: 'error',
            title: error.response.data.message
        });
        
    });
    
    
}

function generateExcel(){
    // $(obj).prop('disabled', true);
    // $('.search').hide();
    let membrete = "";
    let estudios = [];
    let folio = $("#appendComponente")
        .find(".asignEstudio")
        .find(".folioEstudio")
        .val();
    let seleccion = $("input:radio[name=radio_membrete]:checked").val();
    $("#appendComponente").find(".asignEstudio").each(function (key, value) {
            let clave_estudio = $(this).find(".claveEstudio").text().trim();

            let analitos = [];

            $(this).find(".listDato").each(function (llave, valor) {
                    let id = $(this).find(".idAnalito").val();

                    analitos.push({
                        id: id,
                    });
                });

            estudios.push({
                clave: clave_estudio,
                analitos,
            });
    });

    // Enviar datos para cotejar
    var verifica = '';
    const respuesta = axios.post('/stevlab/captura/export-to-excel',{
        membrete: membrete,
        folio: folio,
        estudios: estudios,
        seleccion: seleccion,
    }).then(function(response){
        window.open(response['data']['xlsx']);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Generando documento'
        });
        // $('.listButtons').find('.invalidateData').attr('disabled', true);
    }).catch(function(error){
        console.log(error);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'No se encontro historial validado para imprimir, por favor valide completamente todos los estudios'
        });
    });
}

