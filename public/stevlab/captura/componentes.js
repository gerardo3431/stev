'use strict';
// Componente principal o cascaron
function componente_principal(referencia, folio, estudio){
    return `<div class="row mb-3 asignEstudio asignEstudio${referencia}"> 
                <input class='folioEstudio' type='hidden' value='${folio}'>
                <label class='form-label'>
                    <h4>
                        <span class='claveEstudio'>
                        ${estudio.clave}
                        </span> 
                        - ${estudio.descripcion}
                    </h4>
                </label>
                <div class='col-md-12 asignAnalito asignAnalito${estudio.id} '>
                </div>
                <div class="mb-3 listButtons">
                    <div class="btn-group float-md-end" role="group" aria-label="Basic example">
                        <button onclick='guardarEstudios(this)' type="submit" class="btn btn-primary saveData guardar${estudio.clave}"
                        ${estudio.validacion === 'validado' ? 'disabled' : ''}>
                            <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                            <i id='saedata' class='mdi mdi-content-save saveEstudio'></i> Guardar
                        </button>
                        <button onclick='validarEstudios(this)' type="submit" class="btn btn-success validateData validar${estudio.clave}" 
                        ${estudio.validacion === 'capturado' ? '' : 'disabled'}>
                            <i class='mdi mdi-file-check'></i> Validar
                        </button>
                        <button onclick='invalidarEstudios(this)' type="submit" class="btn btn-danger invalidateData invalidar${estudio.clave}" 
                        ${estudio.validacion === 'validado' ? '' : 'disabled'}>
                            <i class='mdi mdi-file-excel'></i> Invalidar
                        </button>
                        <button class="btn btn-primary" type="button" onclick="generaPdf(this)">
                            <i class="mdi mdi-file-multiple"></i> Impresión
                        </button>
                    </div>
                </div>
            </div>`;
    // return cascaron;
}

/* <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class='mdi mdi-file-document'></i>Impresión
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
        <a onclick='generaPdf(this)' class="dropdown-item" href="#">Imprimir sin membrete</a>
        <a onclick='generaPdfMembrete(this)' class="dropdown-item" href="#">Imprimir (membrete digital)</a>
    </div>
</div> */
function evaluaValor(analito){
    return analito.valor_captura !== null 
        && analito.valor_captura !== undefined 
        && analito.valor_captura !== '' 
            ? analito.valor_captura 
            : (analito.defecto !== null 
                && analito.defecto !== undefined 
                && analito.defecto !== '' 
                && analito.defecto === NaN
                    ? analito.defecto 
                    : '');
}
// Componentes de tipo analito
function componente_analito(analito, propiedad){
    
    switch (analito.tipo_resultado) {
        case 'subtitulo':
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' id='' value='${analito.id_valor_captura ? analito.id_valor_captura : ''}'>
                        <div class='col-sm-4 col-md-2 ' style= 'display: none;'>
                            <span class='claveDato'>
                                ${analito.clave}
                            </span>
                        </div>
                        <div class="col-sm-8 col-md-4" style= 'display: none;'>
                            <span class='descripcionDato'>
                                ${analito.descripcion}
                            </span>
                        </div>
                        <div class="col-sm-8 col-md-4" style='display:none;'>
                            <input id='subti${analito.clave}' type="text" class="form-control storeDato" value='${analito.valor_referencia}'>
                        </div>
                        <div class="col-sm-4 col-md-2" style= 'display: none;'>
                            <span class='ejemploDato'>
                                ${analito.tipo_resultado}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class='col-md-12'>
                            <strong>${analito.descripcion}</strong>
                        </div>
                    </div>`;
            break;
        case 'texto':
            let input = '';
            let texto = analito.tipo_validacion;
            if(analito.tipo_referencia === "restringido"){
                input += `<select type="text" class="form-select form-control storeDato" ${propiedad === 'validado'  ? "disabled" : ''}>`;
                if(analito.tipo_validacion !== null){
                    let array = texto.split(',');
                    array.forEach(function(index, elemento){
                        input +=`<option value='${index.trim()}' ${analito.valor_captura === index.trim() ? 'selected' : '' }>${index}</option>`;
                    });
                }
                input += '</select>';
            }else if(analito.tipo_referencia == 'abierto'){
                input += `<input type="text" class="form-control storeDato" value='${evaluaValor(analito)}'  ${propiedad === 'validado' ? "disabled" : ''} >` ;
            }

            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${analito.id_valor_captura ? analito.id_valor_captura : ''}'>
                        <div class='col-sm-1 col-md-1'>
                        </div>
                        <div class='col-sm-2 col-md-2'>
                            <span class='claveDato' onclick='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
                                ${analito.clave}
                            </span>
                            <div class='col-md-6 col-xl-3 grid-margin grid-stretch walllingInline' style='z-index:9999; position:absolute; display:none'>
                                <div class='card'>
                                    <div class='card-body'>
                                        <div class='chartOfDuty chartOfDuty${analito.clave}'></div>
                                        <div class='chartData chartData${analito.clave}'> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <span class='descripcionDato'>
                                ${analito.descripcion}
                            </span>
                        </div>
                        <div class="col-sm-3 col-md-3 appendTexto">
                            ${input}
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <span class='ejemploDato'>
                                ${analito.valor_referencia}
                            </span>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                        </div>
                    </div>`;
            break;
        case 'numerico':
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${analito.id_valor_captura ? analito.id_valor_captura : ''}'>
                        <div class='col-sm-1 col-md-1'>
                            <input class="form-check-input activeAbsoluto" type="checkbox" value="" onclick='showAbsolutesInput(this)' ${analito.valor_captura_abs ? 'checked' : ''}>
                        </div>
                        <div class='col-sm-2 col-md-2 '>
                            <span class='claveDato' onclick='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
                                ${analito.clave}
                            </span>
                            <div class='col-md-6 col-xl-3 grid-margin grid-stretch walllingInline' style='z-index:9999; position:absolute; display:none'>
                                <div class='card'>
                                    <div class='card-body'>
                                        <div class='chartOfDuty chartOfDuty${analito.clave}'></div>
                                        <div class='chartData chartData${analito.clave}'> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <span class='descripcionDato'>
                                ${analito.descripcion}
                            </span>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <input type="number" min='0' class="form-control storeDato" value="${evaluaValor(analito)}" ${propiedad === 'validado' ? "disabled" : ''} 
                            onkeyup='evalua_resultados(${analito.numero_uno}, ${analito.numero_dos}, $(this).val(), this)' >
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <span class='ejemploDato'>
                                ${analito.numero_uno} - ${analito.numero_dos}
                            </span>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                        </div>
                        <div class='deployValue row mx-1 my-3' ${analito.valor_captura_abs ? '' : "style='display:none;'" }>
                            <div class='col-sm-1 col-md-1'>
                                <i class='mdi mdi-subdirectory-arrow-right'></i>
                            </div>
                            <div class='col-sm-2 col-md-2'>
                                <span >
                                    ${analito.clave}
                                </span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <span>
                                    ${analito.descripcion}
                                </span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <input type="number" class="form-control storeAbsolute" value="${analito.valor_captura_abs ? analito.valor_captura_abs : ''}" 
                                ${propiedad === 'validado' ? "disabled" : ''}>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <span>
                                    %
                                </span>
                            </div>
                        </div>
                    </div>`;
            break;
        case 'documento':
            // return analito.valor_captura !== null && analito.valor_captura !== undefined && analito.valor_captura !== '' ? analito.valor_captura : (analito.defecto !== null && analito.defecto !== undefined && analito.defecto !== '' ? analito.defecto : '')
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${analito.id_valor_captura ? analito.id_valor_captura : ''}'>
                        <div class='col-sm-1 col-md-1'>
                        </div>
                        <div class='col-sm-2 col-md-2 '>
                            <span class='claveDato'>
                                ${analito.clave}
                            </span>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <span class='descripcionDato'>
                                ${analito.descripcion}
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <textarea class='form-control documento storeDato documento${analito.clave}' name="" id="documento${analito.clave}" cols="15" rows="5" >
                            ${analito.valor_captura !== null && analito.valor_captura !== undefined && analito.valor_captura !== '' ? analito.valor_captura : analito.documento }
                            </textarea>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <span class='ejemploDato text-muted' style="font-size:10px;">
                                Documento
                            </span>
                        </div>
                    </div>`;
            break;
        case 'referencia':
            // console.log(analito);
            let datos = analito.referencia;
            let ejemplito = datos.edad_inicial !== null ? datos.edad_inicial  + ' ' + datos.tipo_inicial + ' a ' + datos.edad_final + ' ' + datos.tipo_final + ': ' + datos.referencia_inicial + ' - ' + datos.referencia_final + '<br>' : 'No indicado, revise';
            // let texto = datos.edad_inicial + ' ' + datos.tipo_inicial + ' a ' + datos.edad_final + ' ' + datos.tipo_final + ': ' + datos.referencia_inicial + ' - ' + datos.referencia_final + '<br>';

            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${analito.id_valor_captura ? analito.id_valor_captura : ''}'>
                        <div class='col-sm-1 col-md-1'>
                            <input class="form-check-input activeAbsoluto" type="checkbox" value="" onclick='showAbsolutesInput(this)' ${analito.valor_captura_abs ? 'checked' : ''}>
                        </div>
                        <div class='col-sm-2 col-md-2'>
                            <span class='claveDato' onclick='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
                                ${analito.clave}
                            </span>
                            <div class='col-md-6 col-xl-3 grid-margin grid-stretch walllingInline' style='z-index:9999; position:absolute; display:none'>
                                <div class='card'>
                                    <div class='card-body'>
                                        <div class='chartOfDuty chartOfDuty${analito.clave}'></div>
                                        <div class='chartData chartData${analito.clave}'> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <span class='descripcionDato'>
                                ${analito.descripcion}
                            </span>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <input type="number" min='0' class="form-control storeDato" value="${evaluaValor(analito)}" ${propiedad === 'validado' ? "disabled" : ''} 
                            onkeyup='evalua_resultados(${analito.referencia.referencia_inicial}, ${analito.referencia.referencia_final}, $(this).val(), this)' >
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <span class='ejemploDato'>
                                ${ejemplito}
                            </span>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                        </div>
                        <div class='deployValue row mx-1 my-3' style='display:none;'>
                            <div class='col-sm-1 col-md-1'>
                                <i class='mdi mdi-subdirectory-arrow-right'></i>
                            </div>
                            <div class='col-sm-2 col-md-2'>
                                <span>
                                    ${analito.clave}
                                </span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <span>
                                    ${analito.descripcion}
                                </span>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <input type="number" class="form-control storeAbsolute" value="${analito.valor_captura_abs ? analito.valor_captura_abs : ''}" 
                                ${propiedad === 'validado' ? "disabled" : ''}>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <span>
                                    %
                                </span>
                            </div>
                        </div>
                    </div>`;
            break;
        case 'imagen':
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${analito.id_valor_captura ? analito.id_valor_captura : ''}'>
                        <div class='col-sm-1 col-md-1'>
                        </div>
                        <div class='col-sm-2 col-md-2 '>
                            <span class='claveDato'>
                                ${analito.clave}
                            </span>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <span class='descripcionDato'>
                                ${analito.descripcion}
                            </span>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <input onchange='uploadImagen(this)'  data-default-file="${analito.valor_captura !== null && analito.valor_captura !== undefined && analito.valor_captura !== '' ? window.location.origin + "/public/storage/" + ((analito.valor_captura !== null && analito.valor_captura !== undefined && analito.valor_captura !== '') ? analito.valor_captura : '') : ''}"  
                            class="dropify storeDato dropImagen" type="file"  ${propiedad === 'validado' ? "disabled='disabled'" : ''}>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <span class='ejemploDato text-muted' style="font-size:10px;">
                                Imagen
                            </span>
                        </div>
                    </div>`;
            break;
        default:
            console.log('Analito no reconocido');
            break;
    }
}

function componente_analito_edit(analito_dato, tipo_dato){
    let analito     = analito_dato;
    let tipo        = tipo_dato;
    
    switch (tipo) {
        case 'texto':
            return `<input type='hidden' class='idAnalito' value=''>
                    <div class='col-sm-1 col-md-1'>
                        <input class="form-check-input activeAbsoluto" type="checkbox" value="">
                    </div>
                    <div class='col-sm-2 col-md-2'>
                        <span class='claveDato' onclick='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
                            ${analito.clave}
                        </span>
                        <div class='col-md-6 col-xl-3 grid-margin grid-stretch walllingInline' style='z-index:9999; position:absolute; display:none'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h6>Grafica</h6>
                                    <div class='chartOfDuty chartOfDuty${analito.clave}'></div>
                                    <div class='chartData chartData${analito.clave}'> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <span class='descripcionDato'>
                            ${analito.descripcion}
                        </span>
                    </div>
                    <div class="col-sm-3 col-md-3 appendTexto">
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <span class='ejemploDato'>
                            ${analito.valor_referencia}
                        </span>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                    </div>`;
            break;
        case 'numerico':
            return `<input type='hidden' class='idAnalito' value=''>
                    <div class='col-sm-1 col-md-1'>
                        <input class="form-check-input activeAbsoluto" type="checkbox" value="">
                    </div>
                    <div class='col-sm-2 col-md-2 '>
                        <span class='claveDato' onclick='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
                            ${analito.clave}
                        </span>
                        <div class='col-md-6 col-xl-3 grid-margin grid-stretch walllingInline' style='z-index:9999; position:absolute; display:none'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h6>Grafica</h6>
                                    <div class='chartOfDuty chartOfDuty${analito.clave}'></div>
                                    <div class='chartData chartData${analito.clave}'> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <span class='descripcionDato'>
                            ${analito.descripcion}
                        </span>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <input type="number" min='0' class="form-control storeDato" onkeyup='evalua_resultados(${analito.numero_uno}, ${analito.numero_dos}, $(this).val(), this)'>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <span class='ejemploDato'>
                            ${analito.numero_uno} - ${analito.numero_dos}
                        </span>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                    </div>`;
            break;
        case 'documento':
            return `<input type='hidden' class='idAnalito' value=''>
                    <div class='col-sm-1 col-md-1 '>
                        <span class='claveDato'>
                            ${analito.clave}
                        </span>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <span class='descripcionDato'>
                            ${analito.descripcion}
                        </span>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <textarea class='form-control documento storeDato' name="" id="documento${analito.clave}" cols="15" rows="5">
                        ${analito.documento}
                        </textarea>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <span class='ejemploDato text-muted'>
                            Documento
                        </span>
                    </div>`;
            break;
        case 'referencia':
            console.log(analito);
            return `<input type='hidden' class='idAnalito' value=''>
                    <div class='col-sm-1 col-md-1'>
                        <input class="form-check-input activeAbsoluto" type="checkbox" value="">
                    </div>
                    <div class='col-sm-2 col-md-2 '>
                        <span class='claveDato' onclick='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
                            ${analito.clave}
                        </span>
                        <div class='col-md-6 col-xl-3 grid-margin grid-stretch walllingInline' style='z-index:9999; position:absolute; display:none'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h6>Grafica</h6>
                                    <div class='chartOfDuty chartOfDuty${analito.clave}'></div>
                                    <div class='chartData chartData${analito.clave}'> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <span class='descripcionDato'>
                            ${analito.descripcion}
                        </span>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <input type="number" min='0' class="form-control storeDato">
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <span class='ejemploDato'>
                        texto
                        </span>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                    </div>`;
            break;
        
        case 'imageno':
            return ` <input type='hidden' class='idAnalito' value=''>
                    <div class='col-sm-1 col-md-1 '>
                        <span class='claveDato'>
                            ${analito.clave}
                        </span>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <span class='descripcionDato'>
                            ${analito.descripcion}
                        </span>
                    </div>
                    <div class="col-sm-3 col-md-3">
                        <div class='storeDato dropImagen'></di>
                    </div>
                    <div class="col-sm-3 col-md-4">
                        <span class='ejemploDato'>
                            Imagen
                        </span>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <a onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></a>
                    </div>`;
            break;
        default:
            console.log('Analito no reconocido');
            break;
    }

}



// Componentes de tipo observacion
function componente_observacion(observacion){
    return ` <div class="mb-3 observacion">
                <input id='id_observacion' class='id_observacion' type='hidden'>
                <label class='form-label' for="">Observaciones</label>
                <textarea name="observaciones_estudio" id="observaciones_estudio" cols="10" rows="3" class='form-control'>${observacion !== null && observacion !== undefined && observacion !== '' ? observacion : 'Sin observaciones guardadas'} </textarea>
            </div>`;
}

