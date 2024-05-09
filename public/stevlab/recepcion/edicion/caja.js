function calcula_cobro(){
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
        
    }else if(descuento < total){
        nuevo_total = total - descuento;
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
        icon: 'success',
        title: 'Calculando',
        });

        cuota = subtotal - pago;
        $('#solicitud_cambio').val('-' + cuota);

    }else if(pago > subtotal){
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
    }else{
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
        $('#solicitud_cambio').val(0);

        // $('#solicitud_pago').val(0);
    }
}

function genera_venta(){
    let factura = '';
    let folio = $('#identificador_folio').val();
    let ingreso = parseFloat($('#solicitud_pago').val());
    let descuento = $('#solicitud_descuento').val();
    let metodo = $('#solicitud_metodo').val();
    let observaciones = $('#solicitud_observaciones').val();
    let ancho = $('#ancho').val();
    let pago_anterior = $('#pago_anterior').val();

    if($("#factura1").is(":checked")){
        factura = 'ticket';
    }else if($("#factura2").is(":checked")){
        factura = 'hoja';
    }

    let estado = '';
    let subtotal = parseFloat($('#solicitud_subtotal').val());
    let pago = parseFloat($('#solicitud_pago').val());

    if(subtotal > pago){
        estado = 'no pagado';
    }else if(pago >=subtotal){
        estado = 'pagado';
    }

    let prueba = [];
    // Lista de estudios
    $('#listEstudios tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        prueba.push(data);
    });

    $('#listPerfiles tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        prueba.push(data);
    });

    $('#boton-pagar').prop('disabled', true);

    const respuesta = axios.post('/stevlab/recepcion/genera-ingreso-edit', {
        identificador_folio: folio,
        descuento: descuento,
        subtotal: subtotal,
        importe: ingreso,
        metodo_pago: metodo,
        // prueba,
        observaciones: observaciones,
        factura_radio: factura,
        pago_anterior: pago_anterior,
        estado: estado,
        ancho: ancho,
        // factura_radio :
    }).then(function(response){
        console.log(response)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        if(response.data.response == true){
            Toast.fire({
                icon: 'success',
                title: response.data.mensaje,
            });
        }else{
            Toast.fire({
                icon: 'error',
                title: 'No se pudo realizar el pago',
            });
        }
        
        // console.log(response);
        
        // let folio = $('#identificador_folio').val();
        let pago = response.data.data;
        let hoja = $('input[name="factura_radio"]:checked').val();

        let queryString = '/stevlab/recepcion/make-note?folio=' + folio + '&pago=' + pago + '&tipo=' + hoja;

        window.open(queryString, '_blank');
        // window.open(response['data']['pdf']);
        // window.open('/public/storage/' + response['data']['data']['pdf']);
        
        setTimeout(function(){
            window.location.href = "../editar";
        },1500);
        // generar_etiqueta(folio);

    }).catch(function(error){
        console.log(error);
    });
}

// function generar_etiqueta(identificador){
//     let ide = identificador;

//     const respuesta = axios.post('/stevlab/recepcion/genera-etiqueta', {
//         id: ide,
//     }).then(function(response){
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });
        
//         Toast.fire({
//         icon: 'success',
//         title: 'Generando etiquetas',
//         });

//         window.open(response['data']['etiquetas']);

//         // setTimeout(function(){
//         //     window.location.reload();
//         // }, 1500);

        
//         window.location.href = "../editar";

//     }).catch(function(error){
//         console.log(error);
//     });    
// }