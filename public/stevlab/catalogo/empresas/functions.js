'use strict';

function mostrarModal(obj){
    $ ('#lista_precio_edit').val(null).trigger ('change');

	var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $('#modalEditar').modal('show');
    let data = $(obj).parent().parent().find('.data').html();

    const response = axios.post('/stevlab/catalogo/getEmpresa', {
        _token: CSRF_TOKEN,
        data: data,
    })  
    .then(res =>  {
        console.log(res.data);
        $('#id').val(res.data.id);
        $('#clave').val(res.data.clave);
        $('#descripcion').val(res.data.descripcion);
        $('#calle').val(res.data.calle);
        $('#colonia').val(res.data.colonia);
        $('#ciudad').val(res.data.ciudad);
        $('#telefono').val(res.data.telefono);
        $('#rfc').val(res.data.rfc);
        $('#email').val(res.data.email);
        $('#contacto').val(res.data.contacto);
        $('#usuario').val(res.data.usuario);
        $('#password').val(res.data.password);
        $('#descuento').val(res.data.descuento);
        $('#EditDropify').val(res.data.EditDropify);
        $('#fecha_nacimiento').val(res.data.fecha_nacimiento);


        var option = new Option(`${res.data.nombre_lista}`, `${res.data.id_lista}`, true, true);
        $('#lista_precio_edit').append(option).trigger('change');
        // lista_precio_edit

        // 
    }).catch((err) => {
        console.log(err);
    });
}