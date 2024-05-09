'use strict';

function changeStatus(){
    let estado = $('#inventario').prop("checked");

    let value = (estado==true) ? 1 : 0 ; 

    const send = axios.get('/stevlab/utils/checkInventario', {
        params:{
            estado: value
        }
    }).then(function(success){
        console.log(success);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        if(success.data.response == true){
            Toast.fire({
                icon: 'success',
                title: 'Inventario activado',
            });

        }else{
            Toast.fire({
                icon: 'error',
                title: 'Inventario no activado, reintente por favor.',
            });
        }

        
        setTimeout(function(){
            window.location.reload();
        }, 1000);

    }).catch(function(error){
        console.log(error);
    }).finally(function(){
    })
}