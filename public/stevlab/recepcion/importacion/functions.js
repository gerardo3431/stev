// Importa Axios si no lo has hecho ya
// import axios from 'axios';

document.addEventListener('DOMContentLoaded', function () {
    const formularios = document.querySelectorAll('form');
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
    
    formularios.forEach(function (formulario) {
        formulario.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar que se envíe el formulario tradicionalmente
            const formData = new FormData(formulario);

            axios.post('/stevlab/recepcion/store-data', formData)
                .then(response => {
                    console.log(response);
                    // Manejar la respuesta exitosa aquí
                    
                    Toast.fire({
                        icon: 'success',
                        title: response.data.msj,
                    });
                    if(response.data.success){
                        formulario.remove();
                    }
                })
                .catch(error => {
                    console.error(error);
                    // Manejar errores de respuesta aquí
                    Toast.fire({
                        icon: 'success',
                        title: response.data.msj,
                    });
                });
        });
    });
});

function deleteThis(obj) {
    $(obj).parent().parent().remove();
}