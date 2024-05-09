'use strict';
function modal_pago(folio){
    $('#modal_pago').modal('show');
    $('#identificador_folio').val(folio)

    const pago = axios.post('/stevlab/caja/calcula-pendiente-pago', {
        identificador: folio,
    }).then(function(response){
        // console.log(response);
        $('#pago_anterior').val(response.data.monto);
        $('#monto_nuevo').val(response.data.all  - response.data.pago - response.data.monto);

        let monto_actual = response.data.total - response.data.monto;
        $('#total_restante').val(response.data.all  - response.data.pago - response.data.monto);
        $('#solicitud_subtotal').val(response.data.all  - response.data.pago - response.data.monto);

        // console.log(monto_actual);
    }).catch(function(error){
        console.log(error);
    });
}

function calcula_cobro(){
    let nuevo_total = 0;
    let total = parseFloat($('#total_restante').val());
    let descuento = parseFloat($('#solicitud_descuento').val());

    if(descuento == 0){
        $('#solicitud_subtotal').val(total);
    }else if(descuento > total){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'Error, no puedes generar descuento mayor al monto total.',
        });

        $('#solicitud_subtotal').val(total);
        // $('#solicitud_descuento').val(0);
        
    }else if(descuento <= total){
        nuevo_total = total - descuento;
        // console.log(nuevo_total);

        $('#solicitud_subtotal').val(nuevo_total);
        
    }else {
        $('#solicitud_subtotal').val(total);
    }
}

function calcula_cambio(){
    let cuota = 0;
    let subtotal = parseFloat($('#solicitud_subtotal').val());
    let pago = parseFloat($('#solicitud_pago').val());

    if(pago < subtotal ){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'error',
        title: 'Debes pagar completo en esta instancia.',
        });


    }else if(pago >= subtotal){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Calculando',
        });

        cuota = pago - subtotal;
        $('#solicitud_cambio').val(cuota);
    }
}

function genera_venta(){
    let prueba = [];
    let factura = '';

    let folio = $('#identificador_folio').val();
    let ingreso = parseFloat($('#solicitud_pago').val());
    let descuento = $('#solicitud_descuento').val();
    let metodo = $('#solicitud_metodo').val();
    let observaciones = $('#solicitud_observaciones').val();
    let pago_anterior = $('#pago_anterior').val();
    let ancho = $('#ancho').val();

    let estado = '';
    let subtotal = parseFloat($('#solicitud_subtotal').val());
    let pago = parseFloat($('#solicitud_pago').val());


    if($("#factura1").is(":checked")){
        factura = 'ticket';
    }else if($("#factura2").is(":checked")){
        factura = 'hoja';
    }

    if(pago<subtotal){
        estado = 'no pagado';
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
            icon: 'error',
            title: 'Pago debe completarse en su totalidad',
        });
    }else if(pago >=subtotal){
        estado = 'pagado';
        // $('#boton-pagar').prop('disabled', true);

        const respuesta = axios.post('/stevlab/recepcion/genera-ingreso-edit', {
            identificador_folio: folio,
            // prueba,
            metodo_pago: metodo,
            importe: ingreso,
            descuento:descuento,
            subtotal: subtotal,
            pago_anterior: pago_anterior,
            observaciones: observaciones,
            factura_radio: factura,
            estado: estado,
            ancho: ancho,
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
                title: 'Generando recibo de pago',
            });
            
            console.log(response);
            // window.open(response['data']['pdf']);
            // window.open('/public/storage/' + response['data']['data']['pdf']);

            // window.location.href = "../recepcion/pendientes";
            if(response.data.success === true ){
                let pago = response.data.data;
                let hoja = $('input[name="factura_radio"]:checked').val();
        
                let queryString = '/stevlab/recepcion/make-note?folio=' + folio + '&pago=' + pago + '&tipo=' + hoja;
        
                window.open(queryString, '_blank');
                // window.open(response['data']['pdf']);
                // window.open('/public/storage/' + response['data']['data']['pdf']);
                
                setTimeout(function(){
                    window.location.href = "../recepcion/pendientes";
                },1500);
            }

        }).catch(function(error){
            console.log(error);
        });
    }
}
