'use strict';

function verifica_pago(folio){
    var verifica = '';
    let saldo = axios.post('/stevlab/captura/verifica-pago-paciente',  {
        folio : folio,
    }).success(function(respuesta){

    }).then(function(response){
        console.log(response);
        if(response.data.msj == true){
        }else{
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
            icon: 'error',
            title: 'Paciente no ha cubrido la totalidad de los servicios adquiridos.'
            });

        }
        // console.log(response);
    }).catch(function(error){
        console.log(error);
    });

    // console.log(saldo);
    return verifica;
}