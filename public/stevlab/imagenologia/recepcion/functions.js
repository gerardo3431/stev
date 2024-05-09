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
    // data.append('estado', estado);
    data.append('area', area);
    
    setTimeout(() => {
        const response = axios.post('/stevlab/imagenologia/search-pictures', data ,{
        }).then(res => {
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

    table.on('click', 'tr', function (){
        $('#appendComponente').empty();
        let folio = '';
        
        var valor = new FormData();
        $(this).find('td:eq(0)').each(function(){
            valor.append('folio',$(this).html());
            folio = $(this).html();
        });

        const response = axios.get('/stevlab/captura/recover-estudios' ,{
            params:{
                folio: folio,
                areaId: $('#selectArea').val(),
            }
        })
        .then(res => {
            console.log(res);
            let dato = res.data.imagenologias;
            
            let titulo = `  <h3>Folio: <span class="badge bg-secondary folioCaptura">${folio}</span></h3>
                            <br>
                            <div class="mb-3">
                                <label class='form-label' for="">Observación general</label>
                                <textarea name="observaciones" id="observaciones" cols="10" rows="3" class='form-control'></textarea>
                            </div>`;
            
            $('#modalEstudio').modal('show');
            $('#appendComponente').append(titulo);
            let observacion_texto = get_observacion_general(folio);

            dato.forEach(element => {
                console.log(element);
                let estudio = element;
                let analito = element.analitos;
                let id = element.id;

                let referencia = element.clave;
                let componente = componente_principal_img(referencia, folio, estudio);
                $('#appendComponente').append(componente);

                analito.forEach(function(analito, key){
                    let clave = analito.clave;
                    let tipo = analito.tipo_resultado;
                    let analito_tipo = componente_analito(analito , tipo);
                    // console.log(analito.clave + ': ' + tipo + ' - ' + analito.tipo_referencia);
                    if(tipo == 'documento'){
                        
                        $('.asignEstudio' + estudio.clave).find('.asignAnalito'+ estudio.id).append(analito_tipo);
                        setTimeout(() => {
                            textarea(analito.clave, analito.documento, estudio.clave);
                        }, 1000);
                    }else if(tipo == 'imagen'){
                        $('.asignAnalito'+ estudio.id).append(analito_tipo);
                        
                    }else{
                    }
                });
                // Verificacion de resultados
                verifica_resultados(folio, referencia, analito);
            });

            setTimeout(() => {
                dropzones();
            }, 1000);

            $('#archivo').val(null);
            $('#imagen').val(null);

            $('#maquilaFile').empty();
            

            if(res.data.msj_img != null){
                Toast.fire({
                    icon: 'info',
                    title: res.data.msj_img,
                });

                $('#maquilaFile').append(`
                    <a type="button" href="${res.data.path_img}" target="_blank" class="btn btn-primary btn-sm">Descargar</a>
                    <a type="button" class="btn btn-primary btn-sm" onclick="eliminaMaquila(this)">Eliminar</a>
                `);
            }

        })
        .catch((err) =>{
            console.log(err);
        });
    });
});


function dropzones(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    var dropzones = Dropzone.instances;
    // $('.dropImagen').dropify();
    for (var i = 0; i < dropzones.length; i++) {
        dropzones[i].destroy();
    }
    
    Dropzone.autoDiscover = false; 
    
        // Crear nuevas instancias de Dropzone con un bucle foreach
    $('.dropImagen').each(function() {
        var myDropzone = new Dropzone(this, { 
            url: '/stevlab/captura/store-imagen-imagenologia',
            sending: function(file, xhr, formData) {
                // console.log($(this.element).parents('#appendComponente').find('.folioEstudio').val());
                formData.append("_token", CSRF_TOKEN);
                formData.append('folio', $(this.element).parents('#appendComponente').find('.folioEstudio').val());
                formData.append('id_analito', $(this.element).parents('.listDato').find('.idAnalito').val());
                formData.append('clave', $(this.element).parents('.listDato').find('.claveDato').text().trim());
                formData.append('descripcion', $(this.element).parents('.listDato').find('.descripcionDato').text().trim());
                formData.append('identificador', $(this.element).parents('.asignEstudio').find('.claveEstudio').text());
            },
            queueComplete: function(){
                if (this.getAcceptedFiles().length > 0) {
                    $.ajax({
                        url: this.options.url,
                        type: 'POST',
                        data:{
                        },
                        success: function(response) {
                            console.log(response)
                            // hacer algo con la respuesta del AJAX
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                            // manejar errores
                        }
                    });
                }
            }, 
            success: function(exito){
                console.log(exito.xhr.response);
                let pars = JSON.parse(exito.xhr.response);
                $(this.element).parents('.asignEstudio').find('.idAnalito').val(pars.id);
                // $('.asignEstudio'+ estudio.clave).find('.asignAnalito'+ estudio.id).find('.idAnalito').val(pars.id);
            }
        });    
    });
}

function eliminaMaquila(obj){
    // console.log($(obj).parents().find(".folioCaptura").text())
    let identificador = $(obj).parents().find(".folioCaptura").text();
    var eliminacion = axios.get('/stevlab/captura/deleteMaquila', {
        params:{
            ID: identificador,
            type: "imagenologia"
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

var BindDataTable = function(response){
    $('#dataTableMetodos').DataTable().destroy();
    var table = $('#dataTableMetodos').DataTable({
        "order": [ 0, 'desc'],
        // responsive: true,
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
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        "createdRow": function( row, data, dataIndex ) {
            if ( data.estatus_solicitud == "solicitado" ) { 
                $(row).addClass('table-primary');
            }else if ( data.estatus_solicitud == "capturado" ) { 
                $(row).addClass('table-secondary');
            }else if ( data.estatus_solicitud == "validado") { 
                $(row).addClass('table-success');
            }else if ( data.estatus_solicitud == "cancelado" ) { 
                $(row).addClass('table-danger');
            }

        }
    });
}




