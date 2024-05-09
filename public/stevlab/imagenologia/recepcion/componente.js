'use strict';
// Componente principal o cascaron
function componente_principal_img(referencia, folio, estudio){

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
                                        <i class='mdi mdi-content-save'></i> Guardar
                                    </button>
                                    <button onclick='validarEstudios(this)' type="submit" class="btn btn-success validateData validar${estudio.clave}" disabled>
                                        <i class='mdi mdi-file-check'></i> Validar
                                    </button>
                                    <button onclick='invalidarEstudios(this)' type="submit" class="btn btn-danger invalidateData invalidar${estudio.clave}" disabled>
                                        <i class='mdi mdi-file-excel'></i> Invalidar
                                    </button>
                                    <button class="btn btn-primary" type="button" onclick="generaPdf(this)">
                                        <i class="mdi mdi-file-multiple"></i> Impresión
                                    </button>
                                </div>
                            </div>
                        </div>`;
    return cascaron;
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
function componente_analito(analito_dato, tipo_dato){
    let analito     = analito_dato;
    let tipo        = tipo_dato;
    
    if(tipo == 'documento'){
        let documento = `<div class="row mb-3 listDato listDato${analito.clave}">
                            <input type='hidden' class='idAnalito' value=''>
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
                            </div>
                        </div>`;
        return documento;
    }else if(tipo == 'imagen'){
        // return `<div class="row mb-3 listDato listDato${analito.clave}">
        //                 <input type='hidden' class='idAnalito' value=''>
        //                 <div class='col-sm-1 col-md-1'>
        //                 </div>
        //                 <div class='col-sm-2 col-md-2 '>
        //                     <span class='claveDato'>
        //                         ${analito.clave}
        //                     </span>
        //                 </div>
        //                 <div class="col-sm-3 col-md-3">
        //                     <span class='descripcionDato'>
        //                         ${analito.descripcion}
        //                     </span>
        //                 </div>
        //                 <div class="col-sm-12 col-md-12">
        //                     <input onchange='uploadImagen(this)'  data-default-file=""  class="dropify storeDato dropImagen" type="file">
        //                 </div>
        //                 <div class="col-sm-1 col-md-1">
        //                     <span class='ejemploDato'>
        //                         Imagen
        //                     </span>
        //                 </div>
        //             </div>`;
        // Numerico
        let imagen = `<div class="row mb-3 listDato listDato${analito.clave}">
                            <input type='hidden' class='idAnalito' value=''>
                            <div class='col-sm-3 col-md-3 '>
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
                                <div id='dropzone${analito.clave}' class='dropzone storeDato dropImagen'></div>
                            </div>
                            <div class="col-sm-3 col-md-4">
                                <span class='ejemploDato'>
                                    Imagen
                                </span>
                            </div>
                        </div>`;
        return imagen;
    }
}