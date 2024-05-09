'use strict';


$(function() {
    // setInterval(valuarTotal, 3000);
});


function valuarTotal(){
    $('#num_total').empty();
    let estudios = 0;
    let profiles = 0;
    let imagenologia = 0;
    let total = 0;

    $('#tablelistEstudios tr').each(function(){
        estudios = estudios + parseFloat($(this).find('td:eq(2)').text());
    });

    $('#tablelistPerfiles tr').each(function(){
        profiles = profiles + parseFloat($(this).find('td:eq(2)').text());
    });

    $('#tablelistImagenologia tr').each(function(){
        imagenologia = imagenologia + parseFloat($(this).find('td:eq(2)').text());
    });

    total = estudios + profiles + imagenologia;
    $('#total').val('$' + total + '.00');
    $('#num_total').val(total);
}


function removeThis(obj){
    $(obj).parent().parent().remove();
    // console.log(obj);
    valuarTotal();

    let id = $(obj).parent().parent().find('th:eq(0)').text();
    // console.log(id);

    if (window.selectedValues.includes(id)) {
        const index = window.selectedValues.indexOf(id);
        if (index > -1) {
            window.selectedValues.splice(index, 1);
        }
        // $(this).val(null).trigger('change'); // Deseleccionar el valor
        console.log(window.selectedValues);
    } 
}


// Pacientes
function abre_modal_pacientes(){
    $('#modal_paciente').modal('show');
}
// / Pacientes
function abre_modal_doctor(){
    $('#modal_doctor').modal('show');
}

// / Empresas
function abre_modal_empresa(){
    $('#modal_empresa').modal('show');
}


// Formatos
function formato_check(){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
    
    var sangre  = $('#check_sangre').prop('checked');
    var vih     = $('#check_vih').prop('checked');
    var micro   = $('#check_exudado').prop('checked');


    const checkboxes = axios.get('/stevlab/recepcion/formatos-pdf', {
        params:{
            sangre: sangre,
            vih: vih,
            micro: micro,
            // identificador: identificador,
        }
    }).then(function(response){
        let responseData = response.data;
        window.open(responseData, '_blank');
    }).catch(function(error){

    }).finally(function (){

    });
    // const checkboxes = axios.post('/stevlab/recepcion/formatos-pdf', {
    //     sangre: sangre,
    //     vih: vih,
    //     micro: micro,
    //     identificador: identificador,
    // }).then((success) => {
    //     console.log(success);
    //     // if( "sangre" in success.data.data){
    //     //     window.open(success.data.data.sangre);
    //     // }
    //     // if("vih" in success.data.data){
    //     //     window.open(success.data.data.vih);
    //     // }
    //     // if("exudado" in success.data.data){
    //     //     window.open(success.data.data.exudado);
    //     // }
    //     let response = success;
    //     var pdfContent = response.data; // Convertir contenido base64 a texto binario
    //     var blob = new Blob([pdfContent], { type: 'application/pdf' });
    //     var downloadLink = document.createElement('a');
    //     downloadLink.href = window.URL.createObjectURL(blob);
    //     downloadLink.download = 'archivo.pdf';
    //     document.body.appendChild(downloadLink);
    //     downloadLink.click();
    //     document.body.removeChild(downloadLink);
    // }).catch((error)=>{
    //     console.log(error);
    //     Toast.fire({
    //         icon: 'error',
    //         title: error.responseJSON.message,
    //     });
    // });
}

function borra_form(){
    // $('#signupForm')
    $('#signupForm')[0].reset();
    $ ('#id_paciente').val(null).trigger ('change');
    $ ('#id_empresa').val(null).trigger ('change');
    $('#tablelistEstudios').empty();
    $('#tablelistPerfiles').empty();
}

function genera_etiquetas(){
    let folio = $('#identificador_folio').val();
    // var sangre  = $('#check_sangre').prop('checked');
    // var vih     = $('#check_vih').prop('checked');
    // var micro   = $('#check_exudado').prop('checked');
    var queryString = '/stevlab/recepcion/genera-etiqueta?id=' + folio;
    window.open(queryString, '_blank');

    // const respuesta = axios.post('/stevlab/recepcion/genera-etiqueta', {
    //     id: folio,
    // }).then(function(response){
    //     const Toast = Swal.mixin({
    //         toast: true,
    //         position: 'top-end',
    //         showConfirmButton: false,
    //         timer: 3000,
    //         timerProgressBar: true,
    //     });
        
    //     Toast.fire({
    //     icon: 'success',
    //     title: 'Generando etiquetas',
    //     });

    //     window.open(response['data']['etiquetas']);

    // }).catch(function(error){
    //     console.log(error);
    // });    
}

function renueva_recepcion(){
    setTimeout(function(){
        window.location.reload();
    }, 1000);
}


$(function(){
    $('#fecha_nacimiento').on('blur', function(){
        var input = $('#fecha_nacimiento').val();
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