'use strict';
// Componente principal o cascaron
function componente_principal(referencia, folio, estudio){
    let cascaron=`    <div class="row mb-3 asignEstudio asignEstudio${referencia}"> 
                            <input class='folioEstudio' type='hidden' value='${folio}'>
                            <label class='form-label'>
                                <h4>
                                    <span class='claveEstudio'>
                                    ${estudio.clave}
                                    </span> 
                                    - ${estudio.descripcion}
                                </h4>
                            </label>
                            <div class='col-md-12 asignAnalito asignAnalito${estudio.id}'>
                            </div>
                            <div class="mb-3 listButtons">
                                <div class="btn-group float-md-end" role="group" aria-label="Basic example">
                                    <button onclick='guardarEstudios(this)' type="submit" class="btn btn-primary saveData guardar${estudio.clave}">
                                        <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                        <i id='saedata' class='mdi mdi-content-save saveEstudio'></i> Guardar
                                    </button>
                                    <button onclick='validarEstudios(this)' type="submit" class="btn btn-success validateData validar${estudio.clave}" disabled>
                                        <i class='mdi mdi-file-check'></i> Validar
                                    </button>
                                    <button onclick='invalidarEstudios(this)' type="submit" class="btn btn-danger invalidateData invalidar${estudio.clave}" disabled>
                                        <i class='mdi mdi-file-excel'></i> Invalidar
                                    </button>
                                    
                                </div>
                            </div>
                            
                        </div>`;
                        
                        // <button class="btn btn-primary" type="button" onclick="generaPdf(this)">
                        //     <i class="mdi mdi-file-multiple"></i> Impresión
                        // </button>
    return cascaron;
}

// Componentes de tipo analito
function componente_analito(analito_dato, tipo_dato){
    let analito     = analito_dato;
    let tipo        = tipo_dato;
    // Para rellenar si viene capturado
    let id_value = (analito.historial_id != null) ? analito.historial_id  : '';
    let value = (analito.resultado_esperado != null) ? analito.resultado_esperado  : '';

    switch (tipo) {
        case 'subtitulo':
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' id='' value='${id_value}'>
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
                            <strong>${analito.valor_referencia}</strong>
                        </div>
                    </div>`;
            break;
        case 'texto':
            // Anexo opciones si el analito esta  restringido
            let options = "";
            if(analito.tipo_referencia === "restringido"){
                let texto = analito.tipo_validacion;
                if(texto != null){
                    let array = texto.split(',');
                    array.forEach(function(index, elemento){
                        // Si el valor capturado es igual al valor en el arreglo hago la seleccion
                        if(value === index.trim()){
                            options = options + `<option value='${index.trim()}' selected>${index}</option>`;
                        }else{
                            options = options + `<option value='${index.trim()}'>${index}</option>`;
                        }
                    });
                }
            }

            // Consulto cual proporcionar al componente analito
            let text = analito.tipo_referencia === "restringido" ? `<select class='form-select form-control storeDato'>${options}</select>` : `<input type="text" class="form-control storeDato" value='${value}' >` ;
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${id_value}'>
                        <div class='col-sm-1 col-md-1'>
                        </div>
                        <div class='col-sm-2 col-md-2'>
                            <span class='claveDato' onmouseenter='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
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
                            ${text}
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
                        <input type='hidden' class='idAnalito' value='${id_value}'>
                        <div class='col-sm-1 col-md-1'>
                            <input class="form-check-input activeAbsoluto" type="checkbox" value="" ${(analito.resultado_abs === null || analito.resultado_abs === "") ? '' : 'checked'}  onclick='showAbsolutesInput(this)'>
                        </div>
                        <div class='col-sm-2 col-md-2 '>
                            <span class='claveDato' onmouseenter='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
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
                            <input type="number" min='0' class="form-control storeDato" value='${value}' onkeyup='evalua_resultados(${analito.numero_uno}, ${analito.numero_dos}, $(this).val(), this)'>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <span class='ejemploDato'>
                                ${analito.numero_uno} - ${analito.numero_dos}
                            </span>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                        </div>
                        <div class='deployValue row mx-1 my-3' ${(analito.resultado_abs === null || analito.resultado_abs === '') ? "style='display:none;'" : ""}  >
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
                                <input type="text" class="form-control storeAbsolute" value="${(analito.resultado_abs !== null || analito.resultado_abs !== "") ?  parseFloat(analito.resultado_abs) : ''} ">
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
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${id_value}'>
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
                            <textarea class='form-control documento storeDato' name="" id="documento${analito.clave}" cols="15" rows="5">
                            ${analito.resultado_esperado != null ? analito.resultado_esperado : analito.documento}
                            </textarea>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <span class='ejemploDato text-muted'>
                                Documento
                            </span>
                        </div>
                    </div>`;
            break;
        case 'referencia':
            return `<div class="row mb-3 listDato listDato${analito.clave}">
                        <input type='hidden' class='idAnalito' value='${id_value}'>
                        <div class='col-sm-1 col-md-1'>
                            <input class="form-check-input activeAbsoluto" type="checkbox" ${(analito.resultado_abs === null || analito.resultado_abs === "")  ? '' : 'checked'} value="" onclick='showAbsolutesInput(this)'>
                        </div>
                        <div class='col-sm-2 col-md-2'>
                            <span class='claveDato' onmouseenter='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
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
                            <input type="number" min='0' class="form-control storeDato" value='${value}'>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <span class='ejemploDato'>
                                ${(analito.texto_referencial) ? analito.texto_referencial : 'Sin valores referenciales'}
                            </span>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <button onclick="editAnalito(this)" type="submit" class="edicion btn btn-xd btn-icon btn-info text-white" ><i class="mdi mdi-flask-empty"></i></button>
                        </div>
                        <div class='deployValue row mx-1 my-3' ${(analito.resultado_abs !== null || analito.resultado_abs !== '') ? "style='display:none;'" : ""}>
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
                                <input type="text" class="form-control storeAbsolute" value="${(analito.resultado_abs !== null || analito.resultado_abs !== "") ? parseFloat(analito.resultado_abs) : ''}">
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
                        <input type='hidden' class='idAnalito' value='${id_value}'>
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
                            <input onchange='uploadImagen(this)'  data-default-file=""  class="dropify storeDato dropImagen" type="file">
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <span class='ejemploDato'>
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
                        <span class='claveDato' onmouseenter='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
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
                        <span class='claveDato' onmouseenter='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
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
            
            return `<input type='hidden' class='idAnalito' value=''>
                    <div class='col-sm-1 col-md-1'>
                        <input class="form-check-input activeAbsoluto" type="checkbox" value="">
                    </div>
                    <div class='col-sm-2 col-md-2 '>
                        <span class='claveDato' onmouseenter='check_delta(this, "${analito.clave}")' onmouseleave='uncheck_delta(this)'>
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
function componente_observacion(){
    let observacion = ` <div class="mb-3 observacion">
                            <input id='id_observacion' class='id_observacion' type='hidden'>
                            <label class='form-label' for="">Observaciones</label>
                            <textarea name="observaciones_estudio" id="observaciones_estudio" cols="10" rows="3" class='form-control'></textarea>
                        </div>`;
    return observacion;
}
