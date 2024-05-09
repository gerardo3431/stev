'use strict';

function genera_reporte(identificador){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    const promesa = axios.post('/stevlab/caja/genera-reporte-dia', {
        _token: CSRF_TOKEN,
        id: identificador,
    }).then(function(response){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Generando reporte',
        });
        window.open(response['data']['pdf']);
    }).catch(function(error){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'No se pudo generar reporte.',
        });
        console.log(error);
    });
}

function genera_reporte_folios(identificador){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    const promesa = axios.post('/stevlab/caja/genera-reporte-dia-pacientes', {
        _token: CSRF_TOKEN,
        id: identificador,
    }).then(function(response){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Generando reporte',
        });
        window.open(response['data']['pdf']);
    }).catch(function(error){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'No se pudo generar reporte.',
        });
        console.log(error);
    });
}

function genera_reporte_rapido(identificador){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    const promesa = axios.post('/stevlab/caja/genera-reporte-rapido', {
        _token: CSRF_TOKEN,
        id: identificador,
    }).then(function(response){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Generando reporte',
        });
        window.open(response['data']['pdf']);
    }).catch(function(error){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'No se pudo generar reporte.',
        });
        console.log(error);
    });
}

function genera_reporte_rango(identificador){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    let fecha_inicio    = $('#fecha_inicial').val();
    let fecha_final     = $('#fecha_final').val();


    let data = new FormData();

    data.append('fecha_inicio', fecha_inicio);
    data.append('fecha_final', fecha_final);

    const promesa = axios.post('/stevlab/caja/genera-reporte-rango', data, {
    }).then(function(response){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Generando reporte',
        });
        window.open(response['data']['pdf']);
    }).catch(function(error){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'No se pudo generar reporte.',
        });
        console.log(error);
    });
}

function show_modal_retiro(obj, caja){
    $('#modal-retiro-caja').modal('show');
    $('#caja_span').append(`<h4>${obj} - Retiro de caja </h4>`);
    $('#caja').val(obj);
    $('#total_caja').val(caja);
}

function genera_retiro(){

}

function revisaRetiro(){
    let total = $('#total_caja').val();
    let cantidad = $('#cantidad').val();

    if((cantidad != 0) <= total){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Cantidad válida para retirar'
        });
    }else{
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'Cuidado: al retirar esta cantidad, puede provocar incongruencias en los ingresos totales de la caja con los retiros totales.'
        });
    
    }
}

// function block(obj){
//     $(obj).prop('disabled', true);
// }