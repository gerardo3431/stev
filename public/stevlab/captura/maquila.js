'use strict';

$('#maquilar_archivos').on('click', function(){
    let folio = ($('.folioEstudio').val() != null )  ? $('.folioEstudio').val() : $('.folioCaptura').text(); 

    let formulario = new FormData();
    formulario.append("folio", folio);
    formulario.append("archivo", $('#archivo')[0].files[0]);
    formulario.append("imagen", $('#imagen')[0].files[0]);

    $('#maquilar_archivos').prop('disabled', true);
    $('.search').show();
    
    const data = axios.post('/stevlab/captura/maquila-file' , formulario ,{
        headers: {
            'Content-Type': 'multipart/form-data'
        },
    }).then(function(response){
        console.log(response);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    
        Toast.fire({
            icon: 'info',
            title: response.data.msj,
        });
        
        window.open(response['data']['pdf']);

        $('#maquilar_archivos').prop('disabled', false);
        $('.search').hide();

        $('#archivo').parent().find(".dropify-clear").trigger('click');
        $('#imagen').parent().find(".dropify-clear").trigger('click');

        
    }).catch(function(error){
        $('#maquilar_archivos').prop('disabled', false);
        $('.search').hide();

        console.log(error);
    });
});