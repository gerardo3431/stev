'use strict';

function get_users(){
    const response = axios.post('/stevlab/administracion/get_users', {
        sucursal : $('#sucursal').val(),
    }).then(function(response){
         // Notificacion
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        
        Toast.fire({
        icon: 'success',
        title: 'Actualizando busqueda'
        });
        // console.log(response);
        let usuarios = response.data;
        $('#listUsers').empty();
        usuarios.forEach(function(index, element){
            let usuario = ` <tr>
                                <td>${index.id}</td>
                                <td>${index.username}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>`;
            $('#listUsers').append(usuario);
        });
    }).catch(function(error){

    });
}
$(function(){
    $('#checkedAll').on('change', function () {
        // Buscar todos los checkboxes dentro del formulario
        var checkboxes = $('#permisosForm').find(':checkbox');
    
        // Establecer el estado de los checkboxes según el estado del "Seleccionar Todos"
        checkboxes.prop('checked', $(this).prop('checked'));
    });

});