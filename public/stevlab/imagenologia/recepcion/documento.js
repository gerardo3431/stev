"use strict";

// Genera pdf con membrete
function generaPdf(obj){
    let membrete = '';
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

// function para enviar ajax a la generacion de documento
function make_pdf(estudios, folio, clave_estudio, membrete) {
    let seleccion = $("input:radio[name=radio_membrete]:checked").val();
    var verifica = "";
    const documento = axios
        .post("/stevlab/captura/genera-resultados-imagenologia", {
            estudios,
            folio: folio,
            clave: clave_estudio,
            membrete: membrete,
            seleccion: seleccion,
        })
        .then(function (response) {
            console.log(response);
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "success",
                title: "Generando pdf... Espere por favor",
            });
            window.open(response["data"]["pdf"]);
        })
        .catch(function (error) {
            // Notificacion
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "No se puede generar documento, verifique que los resultados esten validados.",
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
                sendajax(membrete, estudios, folio, seleccion);
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                membrete = 'no';
                sendajax(membrete, estudios, folio, seleccion);
            }
        });
}

function sendajax(membrete, estudios, folio, seleccion) {
    var verifica = "";
    const respuesta = axios
        .post("/stevlab/captura/generate-all-result-imagenologia", {
            membrete: membrete,
            folio: folio,
            estudios: estudios,
            seleccion: seleccion,
        })
        .then(function (response) {
            console.log(response);
            window.open(response["data"]["pdf"]);
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: "success",
                title: "Generando documento",
            });
        })
        .catch(function (error) {
            console.log(error);
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "error",
                title: "No se encontro historial validado para imprimir, por favor valide completamente todos los estudios",
            });
        });
}
