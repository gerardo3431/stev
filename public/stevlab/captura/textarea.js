'use strict';

// var text_documento;
const ckeditorInstances = {};

function textarea(clave, documento, estudio, status){
    let elemento = document.querySelector('.asignEstudio'+estudio).querySelector('#documento'+clave);
    ClassicEditor.create(elemento)
        .then(texto =>{
            
            ckeditorInstances['documento' + clave] = texto;

            if(status === true){
                texto.enableReadOnlyMode('#documento' + clave);
            }

        })
        .catch( error => {
            console.error( error );
        } );
}

function bloquearEditor(clave) {
    
    let instancia = ckeditorInstances['documento' + clave];
    // console.log(ckeditorInstances);
    // console.log(instancia);
    if (instancia) {
        if(instancia.isReadOnly === false){
            ckeditorInstances['documento'  + clave].enableReadOnlyMode('#documento' + clave);
        }else{
            ckeditorInstances['documento'  + clave].disableReadOnlyMode('#documento' + clave);
        }
    } else {
        // console.error('CKEditor no encontrado para la clave ' + clave);
    }
}