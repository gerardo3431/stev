'use strict'


function editarPicture(obj){
    $('#edit_imagenologia')[0].reset();
    $('#modalPicture').modal('show');

    let id = obj;

    const envio = axios.get('/stevlab/catalogo/getPicture', {
        params:{
            ID: id
        }
    }).then(function(response){
        console.log(response);
        $('#identificador').val(response.data.id);
        $('#edit_clave').val(response.data.clave);
        $('#edit_codigo').val(response.data.codigo);
        $('#edit_descripcion').val(response.data.descripcion);
        $('#edit_area').val(response.data.area);
        $('#edit_condiciones').val(response.data.condiciones);
        $('#edit_precio').val(response.data.precio);
    }).catch(function(error){
        console.log(error);
    }).finally(function(){
        
    });
}