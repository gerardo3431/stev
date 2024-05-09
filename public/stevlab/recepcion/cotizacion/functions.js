'use strict';

function valuarTotal(){
    $('#num_total').empty();
    let estudios = 0;
    let profiles = 0;
    let img = 0;
    let total = 0;

    $('#tablelistEstudios tr').each(function(){
        estudios = estudios + parseFloat($(this).find('td:eq(2)').text());
    });

    $('#tablelistPerfiles tr').each(function(){
        profiles = profiles + parseFloat($(this).find('td:eq(2)').text());
    });

    $('#tablelistImagenologia tr').each(function(){
        img = img + parseFloat($(this).find('td:eq(2)').text());
    });

    total = estudios + profiles + img;
    $('#num_total').val('$' + total + '.00');
    
}


function removeThis(obj){
    $(obj).parent().parent().remove();
    valuarTotal();
}

function enviarmsj(){
    let estudios = [];
    let perfiles = [];
    let img = [];
    let nombre = $('#nombre').val();
    let empresa = $('#id_empresa').val();
    let observaciones = $('#observaciones').val();
    let total = $('#num_total').val();
    let telefono = $('#telefono').val();

    let lista = '';
    $('#tablelistEstudios tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        estudios.push(data);
        // lista = lista + data. descripcion + '\n';
    });

    $('#tablelistPerfiles tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        perfiles.push(data);
        // lista = lista + data.descripcion + '\n';
    });

    $('#tablelistImagenologia tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        img.push(data);
        // lista = lista + data.descripcion + '\n';
    });
    

    // let mensaje = `Hola estimado(a) ${nombre}, por medio de la presente se le envia la cotización que solicito: \n\n${lista}\nCon un costo de ${total}. \nObservaciones anexas: \n${observaciones}`;


    // Invocamos al ajax por axios.min.js para hacer las operaciones en el controlador
    const response = axios.post('/stevlab/recepcion/cotizar-estudio-whatsapp', {
        nombre: nombre,
        empresa: empresa,
        observaciones: observaciones,
        total: total,
        estudios,
        perfiles,
        img,
        telefono: telefono,
        // mensaje: encodeURI(mensaje)

    }).then(res => {
        console.log(res);
        window.open(res['data']['url']);
        // window.open(res['data']['pdf']);

    }).catch((err) => {
        console.log(err);
    });
}