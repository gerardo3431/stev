'use strict';

function mostrarModal(obj){
	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $('#modalEditar').modal('show');
    let data = $(obj).parent().parent().find('.data').html();

    const response = axios.post('/stevlab/catalogo/getDoctor', {
        _token: CSRF_TOKEN,
        data: data,
    })
    .then(res =>  {
        console.log(res.data);
        $('#id').val(res.data.id);
        $('#clave').val(res.data.clave);
        $('#usuario').val(res.data.usuario);
        $('#password').val(res.data.password);
        $('#nombre').val(res.data.nombre);
        $('#ap_paterno').val(res.data.ap_paterno);
        $('#ap_materno').val(res.data.ap_materno);
        $('#telefono').val(res.data.telefono);
        $('#celular').val(res.data.celular);
        $('#email').val(res.data.email);
        // 
    }).catch((err) => {
        console.log(err);
    });
}