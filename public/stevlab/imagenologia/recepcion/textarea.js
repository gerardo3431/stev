'use strict';

var text_documento;
function textarea(clave, documento, estudio){
    let docu = documento;
    ClassicEditor
            .create( document.querySelector('.asignEstudio'+estudio)
                        .querySelector('#documento'+clave))
            .then(texto =>{
                
            })
            .catch( error => {
                console.error( error );
            } );

}