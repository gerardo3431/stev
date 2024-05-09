'use strict';



function evalua_resultados(numero_uno, numero_dos, numero_tres, obj){
    let number_uno  = numero_uno;
    let number_two  = numero_dos;
    let valor       = numero_tres;
    let objeto      = obj;
    // console.log(objeto);
    // $(obj).parents('.asignEstudio').find('.folioEstudio').val();
    // rgb(5, 163, 74) 0px 0px 1px 4px

    if(valor < number_uno || valor > number_two){
        // console.log('menor a valor uno');
        $(objeto).css('box-shadow', '0 0px 1px 3px rgba(255, 51, 102, 0.8)');
    }else{
        // console.log('entre valor uno y dos, correcto');
        $(objeto).css('box-shadow', '0 0px 1px 3px rgb(5, 163, 74, 0.8)');
        // $(obj).parent('.storeDato').css('box-shadow', '#05a34a');
    }
}