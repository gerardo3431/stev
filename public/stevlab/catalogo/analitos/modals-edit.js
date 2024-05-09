function editarAnalito(obj){
    $('#modal-editar-analito').modal('show');

    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();

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

        if(analitos.valida_qr){
            $('#edit_valida_qr').prop('checked', true);
        }
        
        $('#edit_tipo_validacion').val(analitos.tipo_validacion);
        $('#edit_numero_uno').val(analitos.numero_uno);
        $('#edit_numero_dos').val(analitos.numero_dos);
        // $('#edit_documento').val(analitos.documento);
        if(analitos.tipo_resultado === 'documento'){
            // setTimeout(function(){
            //     window.location.reload();
            // }, 3100);
            setTimeout(() => {
                textarea_edit_analito(analitos.documento);
            }, 3600);
        }
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
    console.log(valores);
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
            // console.log(response);

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