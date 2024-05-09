'use strict';
var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

// Mostrar campos para rellenar de acuerdo a lo que soliciten en analito
function displayValues(){
    
    $('#showReferencia').hide();
    $('#showEstado').hide();
    $('#showTipoValidacion').hide();
    $('#showNumerico').hide();
    $('#showDocumento').hide();
    
    let value = $('#tipo_resultado').val();
    
    if(value=='subtitulo'){
        $('#showReferencia').show();
    }else if(value=='texto'){
        $('#showReferencia').show();
        $('#showEstado').show();
        $('#showTipoValidacion').show();
    }else if(value=='numerico'){
        $('#showNumerico').show();
    }else if(value=='documento'){
        $('#showDocumento').show();
    }else{
        $('#showReferencia').hide();
        $('#showEstado').hide();
        $('#showTipoValidacion').hide();
        $('#showNumerico').hide();
        $('#showDocumento').hide();
    }
}

function removeAnalito(obj){

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger me-2'
    },
    buttonsStyling: false,
    })
    
    swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "Eliminarás el analito asignado actualmente. Está acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'me-2',
    confirmButtonText: 'Si, eliminar!',
    cancelButtonText: 'No, cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {
        // var estudio = $('#estudioId').val();
        var estudio = $('#estudioId').val();
        let data = $(obj).parent().text().split('-')[0].trim();
        // Elimina analito de analito
        const response = axios.post('/stevlab/catalogo/eliminaAnalito',{
            _token: CSRF_TOKEN,
            estudio: estudio,
            data: data,
        })
        .then(res => {
            $(obj).parent().remove();
            console.log(res);

            if(res.data.msj){
                swalWithBootstrapButtons.fire(
                    'Eliminado!',
                    res.data.msj,
                    'success'
                );
                // setTimeout(() => {
                //     window.location.reload();
                // }, 300);
            }else if(res.data.error){
                swalWithBootstrapButtons.fire(
                    'Eliminado!',
                    res.data.error,
                    'error'
                );
            }
        })
        .catch((err) =>{
            console.log(err);
        });
        
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
        'Cancelado',
        'Analito no eliminado',
        'error'
        );
    }
    });
    

}

function removeThis(obj){
    $(obj).parent().remove();
}

function sendAnalitos(){
    var estudio = $('#estudioId').val();
    var data = [];
    var numero = 0;
    $('#analitos-list li').each(function(indice, elemento) {
        data[indice]= $(elemento).text().split('-')[0].trim();
        // .replace(/[$]/g,''))
    });

    const response = axios.post('/stevlab/catalogo/asignAnalitos',{
        _token: CSRF_TOKEN,
        estudio: estudio,
        data: data,
    })
    .then(res => {
        console.log(res);
        // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        if(res.data.msj){
            Toast.fire({
                icon: 'success',
                title: res.data.msj,
            });
            // Limpio el campo de identificacion del estudio
            $('#estudioId').val(null);
            // Oculto lista y calculadora
            $('#setAnalito').hide();
            $('#analitos-list').empty();
            $('#calculadora').hide();
            $('#analitos-checklist-list').empty(); 
            
            // setTimeout(() => {
            //     window.location.reload();
            // }, 300);
        }else if(res.data.error){
            Toast.fire({
                icon: 'error',
                title: res.data.error
            });
        }
    })
    .catch((err) =>{
        console.log(err);
    });
}

function removeReferences(obj, value){
    let dato = value;
    let analito = $('#analito').val();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger me-2'
    },
    buttonsStyling: false,
    })
    
    swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "Eliminarás el valor de referencia asignado actualmente. Está acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'me-2',
    confirmButtonText: 'Si, eliminar!',
    cancelButtonText: 'No, cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {

        // Elimina referencia de analito
        $(obj).parent().parent().remove();
        const response = axios.post('/stevlab/catalogo/eliminaReferencia',{
            _token: CSRF_TOKEN,
            referencia: dato,
            analito: analito
        })
        .then(res => {
            $(obj).parent().remove();
            console.log(res);
        })
        .catch((err) =>{
            console.log(err);
        });

        swalWithBootstrapButtons.fire(
        'Eliminado!',
        'Analito retirado del estudio',
        'success'
        );

    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
        'Cancelado',
        'Referencia no eliminado',
        'error'
        );
    }
    });

}

function cerrarModal(){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger me-2'
    },
    buttonsStyling: false,
    })
    
    swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "Terminar de asignar valores referenciales.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'me-2',
    confirmButtonText: 'Confirmar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {
        $('#modalReferencia').modal('hide');
        window.location.reload();
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
        'Cancelado',
        // '',
        'error'
        );
    }
    });
}

function verAnalito(obj){
    $('#modal-ver-analito').modal('show');
    let clave = $(obj).parent().parent().find('td:eq(0)').html();

    const response = axios.post('/stevlab/catalogo/getKeyAnalito',{
        _token: CSRF_TOKEN,
        clave: clave,
    })
    .then(res => {
        console.log(res);
        let analito = res.data;
        let componente = `
            <p class="mb-3">
                <strong>
                    Clave:
                </strong>
                ${analito.clave}
            </p> 
            <p class="mb-3">
                <strong>
                    Descripción:
                </strong>
                ${analito.descripcion}
            </p> 
            <p class="mb-3">
                <strong>
                    Bitacora:
                </strong>
                ${analito.bitacora}
            </p> 
            <p class="mb-3">
                <strong>
                    Condiciones:
                </strong>
                ${analito.defecto}
            </p> 
            <p class="mb-3">
                <strong>
                    Unidad:
                </strong>
                ${analito.unidad}
            </p> 
            <p class="mb-3">
                <strong>
                    Digito:
                </strong>
                ${analito.digito}
            </p> 
            <p class="mb-3">
                <strong>
                    Tipo resultado:
                </strong>
                ${analito.tipo_resultado}
            </p> 
            <p class="text-muted">Para ver en detalle la información, acuda al botón editar</p>
        `;
        $('#cuerpo_ver').empty();
        $('#cuerpo_ver').append(componente);
    })
    .catch((err) =>{
        console.log(err);
    });
}

function getCalculadora(obj){
}

function sendFormulas(){
    var estudio = $('#estudioId').val();
    var data = [];
    $('#analitos-checklist-list li').each(function(indice, elemento) {
        data[indice]= $(elemento).text().trim();
    });

    const response = axios.post('/stevlab/catalogo/save-formulas', {
        _token: CSRF_TOKEN,
        estudio: estudio,
        data: data,
    }).then(function(success){
        console.log(success);

        // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        if(success.data.response == true){
            Toast.fire({
                icon: 'success',
                title: success.data.msj,
            });
        }else{
            Toast.fire({
                icon: 'error',
                title: success.data.msj,
            });
        }

    }).catch(function(err){
        console.log(err);
    });
}

function removeFormula(){
    $(this).parent().remove();
}

function removeTrueFormula(obj, identidad){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger me-2'
    },
    buttonsStyling: false,
    })
    
    swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "Eliminarás la formula asignada actualmente. Está acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'me-2',
    confirmButtonText: 'Si, eliminar!',
    cancelButtonText: 'No, cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {
        // var estudio = $('#estudioId').val();
        var estudio = $('#estudioId').val();
        let data = identidad;
        // Elimina analito de analito
        const response = axios.post('/stevlab/catalogo/elimina-true-formula',{
            _token: CSRF_TOKEN,
            estudio: estudio,
            data: data,
        })
        .then(res => {
            $(obj).parent().remove();
            console.log(res);

            if(res.data.msj){
                swalWithBootstrapButtons.fire(
                    'Eliminado!',
                    res.data.msj,
                    'success'
                );
            }else if(res.data.error){
                swalWithBootstrapButtons.fire(
                    'No eliminado!',
                    res.data.error,
                    'error'
                );
            }
        })
        .catch((err) =>{
            console.log(err);
        });
        
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
        'Cancelado',
        'Analito no eliminado',
        'error'
        );
    }
    });
}

function verifyDisponibilidad(params) {
    
}