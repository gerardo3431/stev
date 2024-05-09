'use strict';


function removeThis(obj){
    $(obj).parent().parent().remove();
    valuarTotal();
}


function enviar_prefolio(){
    let estudios = [];
    let perfiles = [];
    let nombre = $('#nombre').val();
    let id_doctor = $('#id_doctor').val();
    let observaciones = $('#observaciones').val();
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
    
    // Invocamos al ajax por axios.min.js para hacer las operaciones en el controlador
    const response = axios.post('/stevlab/empresa/send-prefolio-whatsapp', {
        nombre: nombre,
        observaciones: observaciones,
        id_doctor: id_doctor,
        estudios,
        perfiles,
        telefono: telefono,
    }).then(res => {
        console.log(res);
        if(res.data.msg == true){
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
            icon: 'success',
            title: 'Guardando registro...',
            });
            window.open(res['data']['url'], "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=400, height=400");
            $('#targetImagen').modal('show');
            $('#identificador').val(res.data.id);
            
            // $("#file").dropzone({
            //     url: 'nobleui.com'
            // });
        }
        // window.open(res['data']['pdf']);

    }).catch((err) => {
        console.log(err);
    });
}


function clear_form(){
    setTimeout(function(){
        window.location.reload();
    }, 1000);
}