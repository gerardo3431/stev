'use strict';

function get_observacion_general(folio){

    let observacion_texto = ''

    const recepcion_folio = axios.post('/stevlab/captura/get-folios-recepcions',{
        folio: folio.trim(),
    }).then(function(returno){
        console.log(returno.data);
        observacion_texto = returno.data;
        $('#observaciones').val(observacion_texto);
    }).catch(function(error){
        console.log(error);
    });

    return observacion_texto;
};

