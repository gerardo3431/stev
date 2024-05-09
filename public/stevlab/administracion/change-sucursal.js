'use strict';

console.log('CARGA DEL SCRIPT CORRECTA');

function change_sucursal(sucursal){
    let target = sucursal;

    const respuesta = axios.post('/stevlab/administracion/cambiar-sucursal', {
        sucursal: target,
    }).then(function(response){
        // console.log(response);
        if(response.data.caja == 'Caja existente sin cerrar'){
            const Notificacion = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Notificacion.fire({
            icon: 'error',
            title: 'Cierre caja antes de cambiar de sucursal',
            });
        }else{
            if(response.data.status == true){
                // const Notificacion = Swal.mixin({
                //     toast: true,
                //     position: 'top-end',
                //     showConfirmButton: false,
                //     timer: 3000,
                //     timerProgressBar: true,
                // });
                
                // Notificacion.fire({
                // icon: 'success',
                // title: 'Cambiando de sucursal',
                // });
    
                setTimeout(function(){
                    window.location.reload();
                }, 10);
            }else{
                // const Notificacion = Swal.mixin({
                //     toast: true,
                //     position: 'top-end',
                //     showConfirmButton: false,
                //     timer: 3000,
                //     timerProgressBar: true,
                // });
                
                // Notificacion.fire({
                // icon: 'error',
                // title: 'No se pudo cambiar a otra sucursal',
                // });
            }
        }


    }).catch(function(error){
        console.log(error);
    });

}