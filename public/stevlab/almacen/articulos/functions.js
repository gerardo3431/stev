'use strict';
const unidad = $('#unidad');
const pieza = $('#pieza');
const cantidad = $('#cantidad');

$('#unidad').on('change', function(){
    let unidad = $('#unidad').val();
    
    if(unidad !== 'pieza'){
        pieza.prop('disabled', false);
    }else{
        pieza.prop('checked', false).prop('disabled', true);
    }
});

$('#pieza').on('change', function(){
    cantidad.prop('disabled', !$(this).is(':checked') ).val( ($(this).is(':checked')) ? cantidad.val() : '');
});