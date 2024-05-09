'use strict';
// Componente principal o cascaron
function componente_principal_img(referencia, folio, estudio){
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
}

{/* <div class="btn-group" role="group">
<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class='mdi mdi-file-document'></i>Impresión
</button>

<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
    <a onclick='generaPdf(this)' class="dropdown-item" href="#">Imprimir sin membrete</a>
    <a onclick='generaPdfMembrete(this)' class="dropdown-item" href="#">Imprimir (membrete digital)</a>
</div>
</div> */}
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
        case 'documento':
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
        case 'imagen':
            console.log(propiedad);
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
                    data-allowed-file-extensions="jpg jpeg zip rar" 
                    class="dropify storeDato dropImagen" type="file"  ${propiedad === 'validado' ? "disabled='disabled'" : ''}>

                </div>
                <div class="col-sm-1 col-md-1">
                    <span class='ejemploDato text-muted' style="font-size:10px;">
                        Imagen
                    </span>
                </div>
            </div>`;
            break;
            // <div id='dropzone${analito.clave}' class='dropzone storeDato dropImagen'></div>
            // <input onchange='uploadImagen(this)'  data-default-file="${analito.valor_captura !== null && analito.valor_captura !== undefined && analito.valor_captura !== '' ? window.location.origin + "/public/storage/" + ((analito.valor_captura !== null && analito.valor_captura !== undefined && analito.valor_captura !== '') ? analito.valor_captura : '') : ''}"  
            // class="dropify storeDato dropImagen" type="file"  ${propiedad === 'validado' ? "disabled='disabled'" : ''}>
        default:
            return alert('Analito no reconocido...');
            break;
    }

    // if(tipo == 'documento'){
    //     let documento = `<div class="row mb-3 listDato listDato${analito.clave}">
    //                         <input type='hidden' class='idAnalito' value=''>
    //                         <div class='col-sm-1 col-md-1 '>
    //                             <span class='claveDato'>
    //                                 ${analito.clave}
    //                             </span>
    //                         </div>
    //                         <div class="col-sm-1 col-md-1">
    //                             <span class='descripcionDato'>
    //                                 ${analito.descripcion}
    //                             </span>
    //                         </div>
    //                         <div class="col-sm-12 col-md-12">
    //                             <textarea class='form-control documento storeDato' name="" id="documento${analito.clave}" cols="15" rows="5">
    //                             ${analito.documento}
    //                             </textarea>
    //                         </div>
    //                         <div class="col-sm-1 col-md-1">
    //                             <span class='ejemploDato text-muted'>
    //                                 Documento
    //                             </span>
    //                         </div>
    //                     </div>`;
    //     return documento;
    // }else if(tipo == 'imagen'){
    //     // Numerico
    //     let imagen = `<div class="row mb-3 listDato listDato${analito.clave}">
    //                         <input type='hidden' class='idAnalito' value=''>
    //                         <div class='col-sm-3 col-md-3 '>
    //                             <span class='claveDato'>
    //                                 ${analito.clave}
    //                             </span>
    //                         </div>
    //                         <div class="col-sm-3 col-md-3">
    //                             <span class='descripcionDato'>
    //                                 ${analito.descripcion}
    //                             </span>
    //                         </div>
    //                         <div class="col-sm-12 col-md-12">
    //                             <div id='dropzone${analito.clave}' class='dropzone storeDato dropImagen'></div>
    //                         </div>
    //                         <div class="col-sm-3 col-md-4">
    //                             <span class='ejemploDato'>
    //                                 Imagen
    //                             </span>
    //                         </div>
    //                     </div>`;
    //     return imagen;
    // }
    
}