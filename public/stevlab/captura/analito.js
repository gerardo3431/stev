'use strict'
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

function editAnalito(obj){
    $('#modal-editar-analito').modal('show');

    let clave = $(obj).parents('.listDato').find('.claveDato').text().trim();

    const pregunta = axios.post('/stevlab/catalogo/get-analito-clave', {
        clave: clave, 
    }).then(function(response){
        console.log(response);
        let analitos = response.data;
        $('#identificador').val(analitos.id);

        $('#edit_clave').val(analitos.clave);
        $('#edit_descripcion').val(analitos.descripcion);
        $('#edit_bitacora').val(analitos.bitacora);
        
        $('#edit_defecto').val(analitos.defecto);
        $('#edit_unidad').val(analitos.unidad);
        $('#edit_digito').val(analitos.digito);
        $('#edit_tipo_resultado').val(analitos.tipo_resultado);
        $('#edit_valor_referencia').val(analitos.valor_referencia);

        // Falta tipo referencia abierto-restringido
        if(analitos.tipo_referencia == 'restrigido'){
            $('#edit_tipo_referencia1').attr('checked', true);
        }else{
            $('#edit_tipo_referencia2').attr('checked', true);
        }
        $('#edit_tipo_validacion').val(analitos.tipo_validacion);
        $('#edit_numero_uno').val(analitos.numero_uno);
        $('#edit_numero_dos').val(analitos.numero_dos);
        // $('#edit_documento').val(analitos.documento);

        textarea_edit_analito(analitos.documento);
        edit_displayValues();
        validar_formulario_edit_analitos();

    }).catch(function(error){
        console.log(error);
    });
}


function edit_displayValues(){
    
    $('#edit_showReferencia').hide();
    $('#edit_showEstado').hide();
    $('#edit_showTipoValidacion').hide();
    $('#edit_showNumerico').hide();
    $('#edit_showDocumento').hide();
    // $('#edit_tipo_resultado').attr('disabled', false);
    let value = $('#edit_tipo_resultado').val();
    
    if(value=='subtitulo'){
        $('#edit_showReferencia').show();
    }else if(value=='texto'){
        $('#edit_showReferencia').show();
        $('#edit_showEstado').show();
        $('#edit_showTipoValidacion').show();
    }else if(value=='numerico'){
        $('#edit_showNumerico').show();
    }else if(value=='documento'){
        $('#edit_showDocumento').show();
    }else{
        $('#edit_showReferencia').hide();
        $('#edit_showEstado').hide();
        $('#edit_showTipoValidacion').hide();
        $('#edit_showNumerico').hide();
        $('#edit_showDocumento').hide();
    }
}

// Validar formulario de edicion
function validar_formulario_edit_analitos(){
    $("#edit_regisAnalito").validate({
        rules: {
            clave:{
                required: true,
                minlength:3,
                alphanumeric: true,
                // remote:{
                //     url: "/catalogo/verifyKeyAnalito",
                //     type:"post",
                //     data:{
                //         _token: CSRF_TOKEN,
                //     }
                // },
            },
            descripcion:  'required',
            alphanumeric: true,
        },
        messages: {
            clave: {
                required:   "Ingrese clave.",
                minlength:  "Debe ingresar al menos 4 caracteres.",
                remote:     "Clave ya registrada para otro analito.",
            },
            descripcion:    'Ingrese descripción.',
            
        },
        errorPlacement: function(error, element) {
            error.addClass( "invalid-feedback" );
            
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            }
        },
        unhighlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        },
        submitHandler: function() {
            actualiza_analitos_ajax();
        }
    });
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[\w.]+$/i.test(value);
    }, "Solo letras y números admitidos.");
}

function recupera_identificador(){
    var identificador = $('#identificador').val();
    
    return identificador;
}

function actualiza_analitos_ajax(){
    // let valor = text_documento.getData();

    let valores = $('#edit_regisAnalito').serializeArray();
    // console.log(valores);
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $.ajax({
        url: '/stevlab/catalogo/update-analito',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            identificador: recupera_identificador(),
            // data: $('#edit_regisAnalito').serialize(),
            data: valores,
        },            
        success: function(response) {
            let datito = JSON.parse(response);
            let componente = componente_analito_edit(datito.data, datito.data.tipo_resultado);
            
            if(datito.data.tipo_resultado == 'texto'){
                $('.listDato' + datito.data.clave).empty();
                $('.listDato' + datito.data.clave).append(componente);
                // $('.asignAnalito'+ estudio.id).append(analito_tipo);
                // Asigna resultados si es de tipo restringido
                if(datito.data.tipo_referencia == "restringido"){
                    $('.listDato' + datito.data.clave).find('.appendTexto').append("<select class='form-select form-control storeDato'></select>");
                    let texto = datito.data.tipo_validacion;
                    let array = texto.split(',');
                    array.forEach(function(index, elemento){
                        $('.listDato' + datito.data.clave).find('.storeDato').append(`<option value='${index.trim()}'>${index}</option>`);
                    });
                }else if(datito.data.tipo_referencia == "abierto"){
                    if($('.listDato' + datito.data.clave).find('.appendTexto').find('.storeDato')){
                        $('.listDato' + datito.data.clave).find('.appendTexto').append(`<input type="text" class="form-control storeDato" value='${(datito.data.defecto != null) ? datito.data.defecto : ''}' >` );
                    }
                }
            } else if(datito.data.tipo_resultado == 'numerico'){
                $('.listDato' + datito.data.clave).empty();
                $('.listDato' + datito.data.clave).append(componente);
            }else if(datito.data.tipo == 'documento'){
                $('.listDato' + datito.data.clave).empty();
                $('.listDato' + datito.data.clave).append(componente);
                setTimeout(() => {
                    textarea(datito.data.clave, datito.data.documento);
                }, 1000);
            }else if(datito.data.tipo_resultado == 'referencia'){
                let folio = $('.folioCaptura').text().trim();
                let referencias = axios.post('/stevlab/verifica-valores-referenciales',{
                    folio: folio,
                    clave: datito.data.clave,
                }).then(function(respons){
                    respons.data.forEach(function(index, element){
                        let texto = index.edad_inicial + ' ' + index.tipo_inicial + ' a ' + index.edad_final + ' ' + index.tipo_final + ': ' + index.referencia_inicial + ' - ' + index.referencia_final + '<br>';
                        $('.listDato'+ analito.clave).find('.ejemploDato').append(texto);

                    });
                }).catch(function(err){
                    console.log(err);
                });
                $('.listDato' + datito.data.clave).empty();
                $('.listDato' + datito.data.clave).append(componente);
                // $('.asignAnalito'+ estudio.id).append(analito_tipo);
            }else if(datito.data.tipo_resultado == 'imagen'){
                // $('.asignAnalito'+ estudio.id).append(analito_tipo);
                $('.listDato' + datito.data.clave).empty();
                $('.listDato' + datito.data.clave).append(componente);
                $('.dropImagen').dropify();
            }


            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: 'success',
                title: 'Analito actualizado correctamente'
            });
            // Reload
            // setTimeout(function(){
            //     window.location.reload();
            // }, 3100);
            
            $('#modal-editar-analito').modal('hide');

        }            
    });
}

function editarImagen(obj){
    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();
    $('#edit-imagen-analito').modal('show');

    const pregunta = axios.post('/stevlab/catalogo/get-analito-clave', {
        clave: clave, 
    }).then(function(response){
        // console.log(response);
        let analitos = response.data;
        let  value = `<input type="hidden" id='analito' name="analito" value="${analitos.id}">`;
        $('#edit_formImagen').prepend(value);
        $('#edit_dropImagen').attr('data-default-file', '../public/storage/' + analitos.imagen);
        prep_update_image();
    }).catch(function(error){
        console.log(error);
    });


}

function editarReferencias(obj){
    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();
    $('#modalReferencia').modal('show');

    obtener_identificador(clave);

    const pregunta = axios.post('/stevlab/catalogo/get-valores-referenciales-clave', {
        clave: clave, 
    }).then(function(response){
        console.log(response);
        let analitos = response.data;

        analitos.forEach(function(element, index){
            let data = `<tr>
                            <th class='text-center'>${element.edad_inicial}</th>
                            <th class='text-center'>${element.tipo_inicial}</th>
                            <th class='text-center'>${element.edad_final}</th>
                            <th class='text-center'>${element.tipo_final}</th>
                            <th class='text-center'>${element.sexo}</th>
                            <th class='text-center'>${element.referencia_inicial}</th>
                            <th class='text-center'>${element.referencia_final}</th>
                            <th class='text-center'>${element.dias_inicio}</th>
                            <th class='text-center'>${element.dias_final}</th>
                            <th class='d-flex align-items-center'>
                            <button  onclick='removeReferences(this, ${element.id})' type="button" class="btn btn-xs btn-danger btn-icon delete">
                                <i class="mdi mdi-delete"></i>
                            </button>
                            </th>
                        </tr>`;
            $('#valoresReferencias').append(data);
        });

        
    }).catch(function(error){
        console.log(error);
    });
    


}

function obtener_identificador(identificador){
    const pregunta = axios.post('/stevlab/catalogo/get-analito-clave', {
        clave: identificador, 
    }).then(function(response){
        // console.log(response);
        let analitos = response.data;
        let  value = `<input type="hidden" id='analito' name="analito" value="${analitos.id}">`;
        $('#referenciaAnalito').prepend(value);
    }).catch(function(error){
        console.log(error);
    });
}

function check_delta(obj,delta){
    // console.log($(obj).parents('.asignEstudio').find('.claveEstudio').text());

    
    const queryDelta = axios.post('/stevlab/captura/delta-check', {
        clave: delta,
        folio: $('.folioEstudio').val(),
        estudio: $(obj).parents('.asignEstudio').find('.claveEstudio').text().trim()
    }).then(resp => {
        var listHtml = '';

        resp.data.forEach(function(element) {
            listHtml += '<li>' + element + '</li>';
        });
        
        // console.log('<ul>' + listHtml + '</ul>');
        $(obj).next('.walllingInline').fadeIn();

        // Para textos
        $(obj).next('.walllingInline').find('.chartData').html('<ul style="list-style-type: none;">' + listHtml + '</ul>');
        // Para valor numerico
        sparkline(delta, resp.data);

    }).catch(err => {
        console.log(err);
    });
}

function uncheck_delta(obj){
    $(obj).next('.walllingInline').hide();
    $(obj).next('.walllingInline').find('.chartData').empty();
}

function sparkline(delta, response){
    // Mouse speed chart start
    var mrefreshinterval = 500; // update display every 500ms
    var lastmousex=-1; 
    var lastmousey=-1;
    var lastmousetime;
    var mousetravel = 0;
    var mpoints = [];
    var mpoints_max = 30;
    $('html').mousemove(function(e) {
        var mousex = e.pageX;
        var mousey = e.pageY;
        if (lastmousex > -1) {
            mousetravel += Math.max( Math.abs(mousex-lastmousex), Math.abs(mousey-lastmousey) );
        }
        lastmousex = mousex;
        lastmousey = mousey;
    });
    var mdraw = function() {
        var md = new Date();
        var timenow = md.getTime();
        if (lastmousetime && lastmousetime!=timenow) {
            var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000);
            mpoints.push(pps);
            if (mpoints.length > mpoints_max)
                mpoints.splice(0,1);
            mousetravel = 0;
            $('#mouseSpeedChart').sparkline(mpoints, { width: mpoints.length*2, tooltipSuffix: ' pixels per second', lineColor: 'rgb(101,113,255)' });
        }
        lastmousetime = timenow;
        setTimeout(mdraw, mrefreshinterval);
    }
    // We could use setInterval instead, but I prefer to do it this way
    setTimeout(mdraw, mrefreshinterval); 
    $(`.chartOfDuty${delta}`).sparkline(response, {type: 'line', width: '150', height: '50', fillColor: 'rgba(102,209,209,.3)', lineColor: 'rgb(102,209,209)'});
}