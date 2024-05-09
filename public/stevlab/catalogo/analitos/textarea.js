'use strict';
var text_documento;
function textarea_edit_analito(documento){
    let docu = documento;
    // console.log(clave);
    ClassicEditor
        .create( document.querySelector( '#edit_documentExample') )
        .then(texto =>{
            text_documento = texto;
            // Asigna el valor que ya tiene guardado
            texto.setData(docu);
        })
        .catch( error => {
            console.error( error );
        });
}