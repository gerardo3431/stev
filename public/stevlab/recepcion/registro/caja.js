'use strict';
$(function(){
    checkdata();
});
// let seleccion = $('input:radio[name=radio_membrete]:checked').val();

function calcula_cobro(){
    let total = parseFloat($('#solicitud_total').val());
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
        let nuevo_total = total - descuento;
        $('#solicitud_subtotal').val(nuevo_total);
    }else {
        $('#solicitud_subtotal').val(total);
    }
}

function calcula_cambio(){
    let cuota = 0;
    let subtotal = parseFloat($('#solicitud_subtotal').val());
    let pago = parseFloat($('#solicitud_pago').val());

    // if(pago > 0){
    //     $('#boton-pagar').attr('disabled', false);
    // }else{
    //     $('#boton-pagar').attr('disabled', true);
    // }

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

function genera_venta(e){
    // let arreglo = $("#formVenta").serialize();
    // let factura = '';
    // let mount = $('#solicitud_total').val();
    let folio = $('#identificador_folio').val();
    // let ingreso = $('#solicitud_pago').val();
    // let descuento = $('#solicitud_descuento').val();
    // let metodo = $('#solicitud_metodo').val();
    // let observaciones = $('#solicitud_observaciones').val();
    // let ancho = $('#ancho').val();
    let prueba = [];
    // Lista de estudios
    $('#tablelistEstudios tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        prueba.push(data);
    });

    $('#tablelistPerfiles tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        prueba.push(data);
    });

    $('#tablelistImagenologia tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        prueba.push(data);
    });

    // console.log(prueba);

    // if($("#factura1").is(":checked")){
    //     factura = 'ticket';
    // }else if($("#factura2").is(":checked")){
    //     factura = 'hoja';
    // }

    let estado = '';
    let subtotal = parseFloat($('#solicitud_subtotal').val());
    let pago = parseFloat($('#solicitud_pago').val());

    if(subtotal > pago){
        estado = 'no pagado';
    }else if(pago >=subtotal){
        estado = 'pagado';
    }

    let arreglo = $("#formVenta").serialize() + "&estado=" + estado;
    // 
    // prueba.forEach((producto, index) => {
    //     arreglo += `&productos[${index}][clave]=${encodeURIComponent(producto.clave)}`;
    //     arreglo += `&productos[${index}][costo]=${encodeURIComponent(producto.costo)}`;
    //     arreglo += `&productos[${index}][descripcion]=${encodeURIComponent(producto.descripcion)}`;
    //     arreglo += `&productos[${index}][tipo]=${encodeURIComponent(producto.tipo)}`;
    // });

    // Simulo que esta trabajando
    $('#boton-pagar').prop('disabled', true);
    $('.search').show();
    $('#casher').hide();

    const respuesta = axios.post('/stevlab/recepcion/genera-ingreso', arreglo, {
    }).then(function(res){
        console.log(res);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
// console.log(res);
        Toast.fire({
            icon: 'success',
            title: res.data.msj,
        });

        $('#boton-pagar').prop('disabled', true);
        $('.search').hide();
        $('#casher').show();
        // if(data.response.response == true){
            // window.location.href = "../editar";
        // }
        
        // window.open('/public/storage/' + res['data']['data']['pdf']);



        let folio = $('#identificador_folio').val();
        let pago = res.data.data;
        let hoja = $('input[name="factura_radio"]:checked').val();

        let queryString = '/stevlab/recepcion/make-note?folio=' + folio + '&pago=' + pago + '&tipo=' + hoja;

        window.open(queryString, '_blank');
        renueva_recepcion();

    }).catch(function(error){
        console.log(error);
    });
}

// function generar_etiqueta(identificador){
//     let ide = identificador;

//     const respuesta = axios.post('/stevlab/recepcion/genera-etiqueta', {
//         id: ide,
//     }).then(function(response){
//         console.log(response);
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });

//         if(response.data.msj){
//         }else{
//             Toast.fire({
//             icon: 'success',
//             title: 'Generando etiquetas',
//             });
            
//             window.open( response['data']['etiquetas']);
            
//         }
        
//         setTimeout(function(){
//             window.location.reload();
//         }, 1000);
        

//     }).catch(function(error){
//         console.log(error);
//     });    
// }

function checkdata(){
    let doctor          = $('#data_id_paciente').val();
    let paciente        = $('#data_id_doctor').val();
    let observaciones   = $('#data_observaciones').val();
    let prefolio        = $('#data_prefolio').val();

    $('#observaciones').val(observaciones);

    if(doctor != undefined){
        const respuesta = axios.post('/stevlab/recepcion/checkDataPrefolio', {
            paciente: paciente,
            doctor: doctor,
            prefolio : prefolio,
        }).then(function(response){
            console.log(response);
            let estudios = response.data.estudios;
            let empresa = response.data.empresa;
            let paciente = response.data.paciente;
            let doctor = response.data.doctor;

            // Para los estudios
            estudios.forEach(element => {
                console.log(element);
                if(element.tipo == 'Estudio'){
                    check_estudio(element);
                }else{
                    check_perfil(element);
                }
            });

            // Para borrar doctor primero
            $ ('#id_doctor').val(null).trigger ('change');
            var option_doc = new Option(doctor.nombre, doctor.id, true, true);
            $('#id_doctor').append(option_doc).trigger('change');
            // Para el paciente
            var option_pat = new Option(paciente.nombre, paciente.id, true, true);
            $('#id_paciente').append(option_pat).trigger('change');
            // Para la empresa
            var option_emp = new Option(empresa.descripcion, empresa.id, true, true);
            $('#id_empresa').append(option_emp).trigger('change');
        }).catch(function(error){
            console.log(error);
        });    
    }
}