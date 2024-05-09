'use strict';

function mostrarModal(obj){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
    $('#modalEditar').modal('show'); 
    let data = $(obj).parent().parent().find('.data').html();
    
    const response = axios.post('/stevlab/catalogo/getPaciente', {
        _token: CSRF_TOKEN,
        data: data, 
    })
    .then(res =>  {
        console.log(res.data);

        if($('#vigencia-inicio-edit').length) {
            $('#vigencia-inicio-edit').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $('#vigencia-inicio-edit').datepicker('setDate', res.data.vigencia_inicio);
        }

        if($('#vigencia-fin-edit').length) {
            $('#vigencia-fin-edit').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $('#vigencia-fin-edit').datepicker('setDate', res.data.vigencia_fin);
        }
        
        if($('#fecha-nacimiento-edit').length) {
            $('#fecha-nacimiento-edit').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $('#fecha-nacimiento-edit').datepicker('setDate', res.data.fecha_nacimiento);
        }
        
        $('#id').val(res.data.id);
        $('#nombre').val(res.data.nombre);
        $('#ap_paterno').val(res.data.ap_paterno);
        $('#ap_materno').val(res.data.ap_materno);
        $('#domicilio').val(res.data.domicilio);
        $('#colonia').val(res.data.colonia);
        $('#sexo').val(res.data.sexo);
        $('#edad').val(res.data.edad);
        
        $('#celular').val(res.data.celular);
        $('#email').val(res.data.email);
        $('#seguro_popular').val(res.data.seguro_popular);
        // 
        if(res.data.id_empresa !== null){
            console.log(res.data.id_empresa !== null);
            // $('#id_empresa_edit').val();
            // Create a DOM Option and pre-select by default
            var newOption = new Option(res.data.empresa, res.data.id_empresa, true, true);
            // Append it to the select
            $('#id_empresa_edit').append(newOption).trigger('change');
        }else{
            $('#id_empresa_edit').empty();
        }

        var estudio_edit = $('#id_empresa_edit').select2({
            placeholder: 'Buscar empresas',
            maximumSelectionLength: 1,
            minimumInputLength: 3,
            dropdownParent: $('#modalEditar'),
            ajax:{
                url: '/stevlab/catalogo/getEmpresas',
                type: 'get',
                delay: '200',
                data: function(params){
                    return {
                        _token: CSRF_TOKEN,
                        q: params.term, 
                    }
                },
                processResults: function(data){
                    var listEmpresas = [];
                    data.forEach(function(element, index){
                        let est_data = {id: element.id, text: `${element.descripcion}`};
                        listEmpresas.push(est_data);
                    });
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: listEmpresas
                    };
                }
            }
        
        });

    }).catch((err) => {
        console.log(err);
    });
}

$(function(){
    $('#fecha_nacimiento').on('blur', function(){
        var input = $('#fecha_nacimiento').val();
        // Supongamos que la fecha de nacimiento es "YYYY-MM-DD"
        let edad = calculaEdad(input);
        $('#edad_or').val(edad);
    });

    $('#fecha_nacimiento_edit').on('blur', function(){
        var input = $('#fecha_nacimiento_edit').val(edad);
        // Supongamos que la fecha de nacimiento es "YYYY-MM-DD"
        let edad = calculaEdad(input);
        $('#edad').val(edad);
    });
});

function calculaEdad(input){
    // Divide la cadena en día, mes y año
    var partesFecha = input.split('/');
    
    // Reorganiza las partes de la fecha en formato "yyyy-mm-dd"
    var fechaFormateada = partesFecha[2] + '-' + partesFecha[1] + '-' + partesFecha[0];
    
    var fechaNacimiento = new Date(fechaFormateada);
    console.log(fechaNacimiento);
    
    // Obtiene la fecha actual
    var fechaActual = new Date();

    // Calcula la diferencia de años
    var edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();

    // Comprueba si ya pasó el cumpleaños de este año
    if (fechaActual.getMonth() < fechaNacimiento.getMonth() || (fechaActual.getMonth() === fechaNacimiento.getMonth() && fechaActual.getDate() < fechaNacimiento.getDate())) {
        edad--; // Ajusta la edad si aún no ha pasado el cumpleaños
    }

    console.log('La edad es:', edad);

    return edad;
}
