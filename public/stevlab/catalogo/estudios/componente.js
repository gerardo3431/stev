'use strict'

function remote_ajax(response, type){
    let estudios = response.data;
    console.log(estudios);
    
    if(type == 'editar'){
        $('#identificador').val(estudios.id);
        $('#edit_clave').val(estudios.clave);
        $('#edit_codigo').val(estudios.codigo);
        $('#edit_descripcion').val(estudios.descripcion);
        $('#edit_condiciones').val(estudios.condiciones);
        $('#edit_aplicaciones').val(estudios.aplicaciones);
        $('#edit_dias_proceso').val(estudios.dias_proceso);
        $('#edit_precio').val(estudios.precio);
        if(estudios.valida_qr){
            $('#edit_valida_qr').prop('checked', true);
        }

        $('#area').val(estudios.area[0].id);
        $('#muestra').val(estudios.muestra[0].id);
        $('#recipiente').val(estudios.recipientes[0].id);
        $('#metodo').val(estudios.metodo[0].id);
        $('#tecnica').val(estudios.tecnica[0].id);



    }else if(type == 'ver'){
        let componente = `
            <p class="mb-3">
                <strong>
                    Clave:
                </strong>
                ${estudios.clave}
            </p> 
            <p class="mb-3">
                <strong>
                    Codigo:
                </strong>
                ${estudios.codigo}
            </p> 
            <p class="mb-3">
                <strong>
                    Descripcion:
                </strong>
                ${estudios.descripcion}
            </p> 
            <p class="mb-3">
                <strong>
                    Condiciones:
                </strong>
                ${estudios.condiciones}
            </p> 
            <p class="mb-3">
                <strong>
                    aplicaciones:
                </strong>
                ${estudios.aplicaciones}
            </p> 
            <p class="mb-3">
                <strong>
                    Dias:
                </strong>
                ${estudios.dias_proceso}
            </p> 
            <p class="mb-3">
                <strong>
                    Precio:
                </strong>
                ${estudios.precio}
            </p> 
            <p class="mb-3">
                <strong>
                    Área:
                </strong>
                ${estudios.area[0].descripcion}
            </p> 
            <p class="mb-3">
                <strong>
                    Muestra:
                </strong>
                ${estudios.muestra[0].descripcion}
            </p> 
            <p class="mb-3">
                <strong>
                    Recipiente:
                </strong>
                ${estudios.recipientes[0].descripcion}
            </p> 
            <p class="mb-3">
                <strong>
                    Método:
                </strong>
                ${estudios.metodo[0].descripcion}
            </p> 
            <p class="mb-3">
                <strong>
                    Tecnica:
                </strong>
                ${estudios.tecnica[0].descripcion}
            </p> 
        `;
        $('#cuerpo_ver').empty();
        $('#cuerpo_ver').append(componente);
    }
}