'use strict';
// Consulta tablas
$('.consultaEstudios').on('change', function(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
    let fecha_inicio    = $('#selectInicio').val();
    let fecha_final     = $('#selectFinal').val();
    let sucursal        = $('#selectSucursal').val();
    let estado          = $('#selectEstudio').val();
    let area            = $('#selectArea').val();
    
    let data = new FormData();
    
    data.append('fecha_inicio', fecha_inicio);
    data.append('fecha_final', fecha_final);
    data.append('sucursal', sucursal);
    data.append('estado', estado);
    data.append('area', area);
    

    setTimeout(() => {
        const response = axios.post('/stevlab/captura/consulta-estudios', data ,{
        }).then(res => {
            console.log(res);
            let dato = res.data;
            BindDataTable(dato);
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
        }).catch((err) =>{
            console.log(err);
        });
    }, 1000);

});



// preparacion
$(function(){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $('.datepicker').datepicker({
        // startDate: '-2m',
        endDate: '0d',
    });

    var table = $('#dataTableMetodos').DataTable({
        "order": [ 0, 'desc'],
        responsive: true,
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
            search: ""
        },
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        }
    });

    // Para abrir vista
    table.on( 'click', 'tr' ,function () {
        mostrarLoader();
        // $('#appendComponente').empty();
        let folio = '';
        
        var valor = new FormData();
        $(this).find('td:eq(0)').each(function(){
            valor.append('folio',$(this).html());
            folio = $(this).html();
        });

        const response = axios.get('/stevlab/captura/recover-estudios', {
            params:{
                folio: folio,
                areaId: $('#selectArea').val(),
            }
        })
        .then(res => {
            console.log(res);
            // console.log(res);
            let dato = res.data.estudios;
            let perfiles = res.data.perfiles;
            
            if(dato === null && perfiles === null){
                alert('Folio no contiene estudios asignados o pertenece al modulo de imagenologia...');
            }else{
                $('#modalEstudio').modal('show');
                $('.asignEstudio').remove();
                $('.clavePrfil').remove();
                //Agregas dato de la consulta del folio
                $('#folioCaptura').empty();
                $('#folioCaptura').append(folio);
                $('#observaciones').empty();
                $('#observaciones').append(res.data.observaciones);
    
                if(dato != undefined){
                    dato.forEach(function(elemento, index){
                        console.log(elemento);
                        let estudio = elemento;
                        let analito = elemento.analitos;
                        let id = elemento.id;
        
                        let referencia = elemento.clave;
                        let componente = componente_principal(referencia, folio, estudio);
                        $('#appendComponente').append(componente);
        
                        // console.log(analito);
                        analito.forEach(function(analito, key){
                            // let clave = analito.clave;
                            // let tipo = analito.tipo_resultado;
                            let analito_tipo = componente_analito(analito, estudio.validacion);
                            
                            switch (analito.tipo_resultado) {
                                case 'subtitulo':
                                    $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'texto':
                                    // Texto
                                    $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'numerico':
                                    $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'documento':
                                    $('.asignEstudio' + estudio.clave).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    setTimeout(() => {
                                        textarea(analito.clave, analito.documento, estudio.clave, (estudio.validacion === 'validado' ? true : false ));
                                    }, 1500);
                                    break;
                                case 'referencia':
                                    $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    break;
                                case 'imagen':
                                    $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                    $('.dropImagen').dropify();
                                    break;
                                default:
                                    console.log('Elemento no es analito');
                                    break;
                            }
                            
                        });
                        // Verificacion de resultados
                        // verifica_resultados(folio, referencia, analito);
                        let observacion = componente_observacion(estudio.observaciones);
                        $(`.asignAnalito${estudio.id}`).append(observacion);

                        //aqui insertarmos las formulas
                        if(elemento.formulas.length > 0){
                            elemento.formulas.forEach(form => {
                                observerFormulas(form, estudio.clave);
                            });
                        }
                    });
                }
                
                // Para perfiles
                if(perfiles != undefined){
                    perfiles.forEach(function(perfil, index){
                        let profile = perfil;
                        let estudios = perfil.estudios;
        
                        // Añadir titulo de perfil
                        let titulo = `<h4 class="clavePrfil"> <span class=' clavPerfil${profile.clave}'>${profile.clave}</span> - ${profile.descripcion}</h4>`;
                        
                        $('#appendComponente').append(titulo);
        
                        // Recorrido de los estudios asignados
                        estudios.forEach(function(elemento, index){
                            console.log(elemento);
                            let estudio = elemento;
                            let analito = elemento.analitos;
                            let id = elemento.id;
            
                            let referencia = elemento.clave;
                            let componente = componente_principal(referencia, folio, estudio);
                        
                            $('#appendComponente').append(componente);
            
                            // Recorrido de la lista de analitos
                            analito.forEach(function(analito, key){
                                
                                //Configuración del analito a mostrar 
                                let analito_tipo = componente_analito(analito, elemento.validacion);
                                switch (analito.tipo_resultado) {
                                    case 'subtitulo':
                                        $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                        break;
                                    case 'texto':
                                        // Numerico
                                        $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                        break;
                                    case 'numerico':
                                        $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                        break;
                                    case 'documento':
                                        $('.asignEstudio' + estudio.clave).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                                        setTimeout(() => {
                                            textarea(analito.clave, analito.documento, estudio.clave, (elemento.validacion === 'validado' ? true : false ));
                                        }, 1500);
                                        break;
                                    case 'referencia':
                                        $('.asignAnalito'+ estudio.id).append(analito_tipo);

                                        break;
                                    case 'imagen':
                                        $('.asignAnalito'+ estudio.id).append(analito_tipo);
                                        $('.dropImagen').dropify();
                                        break;
                                    default:
                                        console.log('Elemento no es analito');
                                        break;
                                }
                            });

                            // Observaciones
                            let observacion = componente_observacion(estudio.observaciones);
                            $(`.asignAnalito${estudio.id}`).append(observacion);
                            // Formulas, de ser existententes
                            if(estudio.formulas.length > 0){
                                estudio.formulas.forEach(form => {
                                    observerFormulas(form, estudio.clave);
                                });
                            }
                        });
                    });
                }
            }
            
            // Finaliza el pintado de información
            $('#archivo').val(null);
            $('#imagen').val(null);

            $('#maquilaFile').empty();
            
            if(res.data.msj != null){
                Toast.fire({
                    icon: 'info',
                    title: res.data.msj,
                });

                $('#maquilaFile').append(
                    `<a type="button" href="${res.data.path}" target="_blank" class="btn btn-primary btn-sm">Descargar</a>
                    <a type="button" class="btn btn-primary btn-sm" onclick="eliminaMaquila(this)">Eliminar</a>`
                );
            }


        })
        .catch((err) =>{
            console.log(err);
        });

        setTimeout(()=>{
            quitarLoader();

        }, 1000);
    });
});


var BindDataTable = function(response){
    $('#dataTableMetodos').DataTable().destroy();
    var table = $('#dataTableMetodos').DataTable({
        "order": [ 0, 'desc'],
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        "language": {
            search: ""
        },
        data: response,
        columns: [
            {data: 'folio'},
            {data: null, render: function(data){
                return data.paciente;
            }},
            {data: null, render: function(data){
                return data.sucursal;
            }},
            {data: null, render: function(data){
                return data.empresa;
            }},
            {data: null, render: function(data){
                return data.contador;
            }},
            {data: null, render: function(data){
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "createdRow": function( row, data, dataIndex ) {
            if ( data.validado == "solicitado" ) { 
                $(row).addClass('table-primary');
            }else if ( data.validado == "capturado" ) { 
                $(row).addClass('table-secondary');
            }else if ( data.validado == "validado") { 
                $(row).addClass('table-success');
            }else if ( data.estatus_solicitud == "cancelado" ) { 
                $(row).addClass('table-danger');
            }

        }
    });
}

function showAbsolutesInput(obj){
    // console.log($(obj));
    if($(obj).is(':checked') == true){
        $(obj).parents('.listDato').find('.deployValue').show();
    }else{
        $(obj).parents('.listDato').find('.deployValue').hide();
    }
}

function eliminaMaquila(obj){
    // console.log($(obj).parents().find(".folioCaptura").text())
    let identificador = $(obj).parents().find(".folioCaptura").text();
    var eliminacion = axios.get('/stevlab/captura/deleteMaquila', {
        params:{
            ID: identificador,
            type: "recepcion"
        }
    }).then(function(response){
        console.log(response);
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        if(response.data == 1){
            Toast.fire({
                icon: 'info',
                title: "Archivo eliminado",
            });
            $(obj).parents().find('#maquilaFile').empty();
        }else{
            Toast.fire({
                icon: 'info',
                title: "Archivo no eliminado",
            });
        }
    }).catch(function(error){
        console.log(error);
    });
}

function observerFormulas(form, clave_estudio){
    // Formula calculada
    let formula_base = form.formula.split('=')[0];
    // Target o campo final
    let formula_trgt= form.formula.split('=')[1];
    // Activar evento
    activateEvent(formula_trgt, formula_base, clave_estudio);
}

// Revisar
function escapeRegExp(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

// Revisar
function activateEvent(target, formula_base, clave_estudio) {
    const regex = /[A-Za-z0-9.]+/g;

    let subcadenas = formula_base.match(regex);

    // Almacena los valores introducidos por el usuario
    const valores = {};

    // Función para calcular y actualizar los valores
    function calcularValores() {
        let formula_calculada = formula_base;
        subcadenas.forEach(element => {
            const valor = valores[element]; // No es necesario usar || 0
            if (valor !== undefined) {
            // Escapar caracteres especiales en la expresión regular
                const regex = new RegExp(escapeRegExp(element), 'g');
                formula_calculada = formula_calculada.replace(regex, valor);
            }
            
        });
    
        let resultado = eval(formula_calculada);
        resultado = resultado.toFixed(2); // Redondear a dos decimales
        $(`.asignEstudio${clave_estudio}`).find(`.listDato${target}`).find('.storeDato').val(resultado);
    }

    // Asigna eventos a los elementos de entrada
    subcadenas.forEach(element => {
        if (/[A-Za-z0-9.]+/g.test(element)) {
            // Elemento es una clave, asocia evento 'blur' a su campo de entrada
            $(`.listDato${element}`).find('.storeDato').on('input change', function () {
                const valor = parseFloat($(this).val());
                valores[element] = isNaN(valor) ? 0 : valor; // Almacena el valor introducido o 0 si no es válido
                calcularValores();
            });
        }
    });
}

