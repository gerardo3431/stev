$(document).ready(function() {
    // Selecciona el elemento de entrada de archivo utilizando el selector adecuado
    var input = $('#archivo');
    
    // Inicializa el plugin Dropify en el elemento de entrada de archivo
    input.dropify();
    
    // Agrega un evento "on" al elemento de entrada de archivo para el evento "change"
    input.on('change', function() {
        // Obtiene el archivo seleccionado
        var file = input[0].files[0];

        var clave = $('#clave').val();
        // Crea un objeto FormData
        var formData = new FormData();
        formData.append('file', file);
        // Agrega otros datos al objeto FormData, si es necesario
        formData.append('clave', clave);

        
        // Realiza una petición POST utilizando Axios
        axios.post('/stevlab/catalogo/upload-list-precios', formData)
        .then(function(response) {
            // Notificacion
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'info',
                title: response.data.message
            });
            
            // Acciones que deseas realizar cuando la petición sea exitosa
            console.log(response);
        }).catch(function(error){
            // Acciones que deseas realizar cuando la petición falle
            console.log(error);
        });
    });
});