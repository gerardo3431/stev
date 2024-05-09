// Literalmente me pregunto que andas haciendo

function cotizarPdf(){
    let estudios = [];
    let perfiles = [];
    let nombre = $('#nombre').val();
    let empresa = $('#id_empresa').val();
    let observaciones = $('#observaciones').val();
    let total = $('#num_total').val();
    let formato = $("input[name='factura_radio']:checked").val();
    // Foreach para recorrer la tabla de los estudios añadidos
    // $('#tablelistEstudios tr').each(function(){
    //     // Clave de cada estudio
    //     estudios.push($(this).find('th:eq(0)').text());
    // });
    // $('#tablelistPerfiles tr').each(function(){
    //     // Clave de cada estudio
    //     perfiles.push($(this).find('th:eq(0)').text());
    // });

    $('#tablelistEstudios tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        estudios.push(data);
    });

    $('#tablelistPerfiles tr').each(function(){
        let data = {
            clave: $(this).find('th:eq(0)').text().trim(),
            descripcion: $(this).find('td:eq(0)').text().trim(),
            tipo: $(this).find('td:eq(1)').text().trim(),
            costo: $(this).find('td:eq(2)').text().trim(),
            };
        perfiles.push(data);
    });


    // Invocamos al ajax por axios.min.js para hacer las operaciones en el controlador
    const response = axios.post('/stevlab/recepcion/cotizar-estudio', {
        nombre          : nombre,
        empresa,
        observaciones   : observaciones,
        total           : total,
        estudios,//Se envia como arreglo
        perfiles,//Se envia como arreglo
        formato         : formato

    }).then(res => {
        console.log(res);
        window.open(res['data']['pdf']);
    }).catch((err) => {
        console.log(err);
    });
}
