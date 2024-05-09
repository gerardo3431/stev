'use strict';

$(function(){
    $('#dataTablePrefolios').on( 'click', 'tr' ,function () {
        let folio = '';
        
        var valor = new FormData();
        $(this).find('td:eq(1)').each(function(){
            valor.append('folio',$(this).html());
            folio = $(this).html();
        });
        // Obtener observacion general
        const response = axios.post('/stevlab/recepcion/recover-prefolios', valor ,{
        })
        .then(res => {
            console.log(res.data);
            $('#id_paciente').val(null).trigger('change');
            $('#id_doctor').val(null).trigger('change');
            $('#observaciones').val();
            $('#tablelistEstudios').empty();
            $('#tablelistPerfiles').empty();
            $('#identificador_folio').empty();

            // console.log(res.data);
            let data = res.data;
            
            $('#modal_prefolio').modal('show');
            // Paciente
            if(data.pacientes[0] != undefined ){
                var option_pac = new Option(data.pacientes[0].nombre, data.pacientes[0].id, true, true);
                $('#id_paciente').append(option_pac).trigger('change');
            }else{
                $('#modal_paciente').modal('show');
                $('#nombre_paciente').val(data.prefolio.nombre);
            }

            // Doctor
            if(res.data.doctor != null){
                var option_doc = new Option(data.doctor.nombre, data.doctor.id, true, true);
                $('#id_doctor').append(option_doc).trigger('change');
            }else{
                $('#modal_doctor').modal('show');
                $('#nombre_doctor').val(data.usuario.name);
            }
            
            $('#observaciones').val(data.prefolio.observaciones);
            $('#identificador_folio').val(data.prefolio.id);
            checkLista(data.estudios);

            // $('#documento').val(data.prefolio.referencias);
            // setTimeout(() => {
            //     ejecutar_documento(data.prefolio.referencias);
            // }, 1000);

            window.open('../../public/storage/' + data.prefolio.adjunto);
        })
        .catch((err) =>{
            console.log(err);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
    
            Toast.fire({
            icon: 'error',
            title: err.response.data.error
            });
        });

    });
});


// Pacientes
function abre_modal_pacientes(){
    $('#modal_paciente').modal('show');
}
// / Pacientes
function abre_modal_doctor(){
    $('#modal_doctor').modal('show');
}

function checkLista(data){
    let estudios = data;
    estudios.forEach(element => {
        console.log(element);
        if(element.tipo = 'Estudio'){
            let tabulacion = tab_estudio(element, 'Estudio');
            $('#tablelistEstudios').append(tabulacion);

        }else if(element.tipo == 'Perfil'){
            let tabulacion = tab_estudio(element, 'Perfil');
            $('#tablelistPerfiles').append(tabulacion);
        }
        // let tabulacion = tab_estudio(element, 'Estudio');
        // $('#listEstudios').append(tabulacion);
    });
}


function tab_estudio(element, tipo){
    console.log(element);
    let btn = '';
    if(tipo == 'Estudio'){
        btn = 'removeThisOfficialEstudio(this)';
    }else{
        btn = 'removeThisOfficialPerfil(this)';
    }
    
    let componente = `  <tr>
                            <th>${element.clave}</th>
                            <td >${element.descripcion}</td>
                            <td>${tipo}</td>
                        </tr>`;
    return componente;
}


function send_prefolio_folio(){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger me-2'
    },
    buttonsStyling: false,
    })
    
    swalWithBootstrapButtons.fire({
    title: '¿Estas seguro?',
    text: "Eliminarás el prefolio actual. Está acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'me-2',
    confirmButtonText: 'Continuar con el proceso!',
    cancelButtonText: 'No, cancelar!',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {
        $.ajax({
            url: '/stevlab/recepcion/send-prefolio-recepcion',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                data: $('#formPrefolio').serializeArray(),
            },
            success: function(response) {
                console.log(response);
                // let dato = JSON.parse(response);
    
                $('#formPrefolio')[0].reset();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                icon: 'success',
                title: 'Realizando cambios',
                });
                // window.location.href('../../stevlab/recepcion/index');
                window.location.replace('../../stevlab/recepcion/index');

                // $('#modal_prefolio').modal('hide');
                // console.log()
            }            
        });
        swalWithBootstrapButtons.fire(
        'Listo!',
        'Generado proceso ',
        'success'
        );
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
        'Cancelado',
        'Prefolio no eliminado',
        'error'
        );
    }
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