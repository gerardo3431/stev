'use strict';

$(function(){
    $('.consultaEstudios').on('change', function(){
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        
        let fecha_inicio    = $('#selectInicio').val();
        let fecha_final     = $('#selectFinal').val();
        let sucursal        = $('#selectSucursal').val();
        let area            = $('#selectArea').val();
        let estudio         = $('#selectEstudio').val();
        
        let data = new FormData();
        
        data.append('fecha_inicio', fecha_inicio);
        data.append('fecha_final', fecha_final);
        data.append('sucursal', sucursal);
        data.append('area', area);
        data.append('estudio', estudio);
        
        setTimeout(() => {
            $('.perfect-scrollbar').empty();
            $('#loadData').show();
    
            const response = axios.post('/stevlab/captura/consulta-estudios-block', data ,{
            }).then(res => {
                let dato = res.data;
    
                // Notificacion
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                icon: 'success',
                title: 'Actualizando busqueda'
                });
    
                // Recorrido de cada folio
                dato.forEach(folio => {
                    let numFolio = folio.folio;
                    let estudios = folio.estudios;
    
                    let paquete = packLabel(numFolio, folio.observaciones);
                    $('.perfect-scrollbar').append(paquete);
    
                    // Despliegue de estudios
                    estudios.forEach(estudio => {
                        let componente = componente_principal(estudio.clave, numFolio, estudio);
                        $(`.appendComponente${numFolio}`).append(componente);
    
                        // Despliegue de analitos
                        let analitos = estudio.analitos;
    
                        // Contabilidad de analitos con estado validado
                        analitos.forEach(function(analito, key){
                            // let clave = analito.clave;
                            // let tipo = analito.tipo_resultado;
                            let analito_tipo = componente_analito(analito, estudio.validacion);
                            
                            switch (analito.tipo_resultado) {
                                case 'subtitulo':
                                    $(`.appendComponente${numFolio}`).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'texto':
                                    // Texto
                                    $(`.appendComponente${numFolio}`).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'numerico':
                                    $(`.appendComponente${numFolio}`).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'documento':
                                    $(`.appendComponente${numFolio}`).find('.asignEstudio' + estudio.clave).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    setTimeout(() => {
                                        textarea(analito.clave, analito.documento, estudio.clave, (estudio.validacion === 'validado' ? true : false ), numFolio);
                                    }, 1500);
                                    break;
                                case 'referencia':
                                    $(`.appendComponente${numFolio}`).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'imagen':
                                    $(`.appendComponente${numFolio}`).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    $(`.appendComponente${numFolio}`).find('.dropImagen').dropify();
                                    break;
                                default:
                                    console.log('Elemento no es analito');
                                    break;
                            }
                            
                        });
                        // Verificacion de resultados
                        // verifica_resultados(folio, referencia, analito);
                        let observacion = componente_observacion(estudio.observaciones);
                        $(`.appendComponente${numFolio}`).find(`.asignAnalito${estudio.id}`).append(observacion);

                        //aqui insertarmos las formulas
                        // if(estudio.formulas.length > 0){
                        //     estudio.formulas.forEach(form => {
                        //         observerFormulas(form, estudio.clave);
                        //     });
                        // }
                    });
    
                });
    
                $('#loadData').hide();
    
            }).catch((err) =>{
                console.log(err);
            });
        }, 2000);
    });

    var scrollbarExample = new PerfectScrollbar('.perfect-scrollbar');
});


function packLabel(folio, observaciones){
    let titulo = ` 
        <div class='appendComponente${folio}'>
            <h3>Folio: <span class="badge bg-secondary folioCaptura folioCaptura${folio}">${folio}</span></h3>
            <br>
            <div class="mb-3">
                <label class='form-label' for="">Observación general</label>
                <textarea name="observaciones" id="observaciones" cols="10" rows="3" class='form-control'>${observaciones !== null ? observaciones: '' }</textarea>
            </div>
        </div>
    `;
    return titulo
}

function showAbsolutesInput(obj){
    // console.log($(obj));
    if($(obj).is(':checked') == true){
        $(obj).parents('.listDato').find('.deployValue').show();
    }else{
        $(obj).parents('.listDato').find('.deployValue').hide();
    }
}