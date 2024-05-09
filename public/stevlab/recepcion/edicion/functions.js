'use strict';


$(function() {
    // setInterval(valuarTotal, 3000);
    // let identificador = $('#identificador').val();
    // verifica_estudios(identificador);
});


function valuarTotal(){
    $('#num_total').empty();
    let estudios = 0;
    let profiles = 0;
    let pictures = 0;
    let total = 0;

    $('#listEstudios tr').each(function(){
        estudios = estudios + parseFloat($(this).find('td:eq(2)').text());
    });

    $('#listPerfiles tr').each(function(){
        profiles = profiles + parseFloat($(this).find('td:eq(2)').text());
    });

    $('#listImagenes tr').each(function(){
        pictures = pictures + parseFloat($(this).find('td:eq(2)').text());
    });

    total = estudios + profiles + pictures;
    $('#num_total').val('$' + total + '.00');
    
}

function removeThis(obj){
    $(obj).parent().parent().remove();
    valuarTotal();
}

function removeThisOfficialEstudio(obj){
    let identificador = $('#identificador').val();
    let estudio = $(obj).parent().parent().find('th:eq(0)').html();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-2'
        },
        buttonsStyling: false,
    })
    swalWithBootstrapButtons.fire({
        title: 'Estás seguro?',
        text: "Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'me-2',
        confirmButtonText: 'Si, eliminalo!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
    if (result.value) {
        let eliminar = axios.post('/stevlab/recepcion/remove-edit-estudio-folio', {
            estudio: estudio,
            folio: identificador,
        }).then(function(response){
            $(obj).parent().parent().remove();
            valuarTotal();
        }).catch(function(error){
            console.log(error);
        });
        swalWithBootstrapButtons.fire(
            'Eliminado!',
            'Estudio eliminado de la solicitud.',
            'success'
        )
        } else if (
          // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
        ) {
        swalWithBootstrapButtons.fire(
            'Cancelado',
            'Estudio no removido.',
            'error'
            )  
        }
    });
    valuarTotal();
}

function removeThisOfficialPerfil(obj){
    let identificador = $('#identificador').val();
    let perfil = $(obj).parent().parent().find('th:eq(0)').html();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-2'
        },
        buttonsStyling: false,
    })
    swalWithBootstrapButtons.fire({
        title: 'Estás seguro?',
        text: "Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'me-2',
        confirmButtonText: 'Si, eliminalo!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
    if (result.value) {
        let eliminar = axios.post('/stevlab/recepcion/remove-edit-perfil-folio', {
            perfil: perfil,
            folio: identificador,
        }).then(function(response){
            $(obj).parent().parent().remove();
        }).catch(function(error){
            console.log(error);
        });
        swalWithBootstrapButtons.fire(
            'Eliminado!',
            'Perfil eliminado de la solicitud.',
            'success'
        )
        } else if (
          // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
        ) {
        swalWithBootstrapButtons.fire(
            'Cancelado',
            'Perfil no removido.',
            'error'
            )  
        }
    });
    // $(obj).parent().parent().remove();
    valuarTotal();
}

function removeThisOfficialImg(obj){
    let identificador = $('#identificador').val();
    let perfil = $(obj).parent().parent().find('th:eq(0)').html();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-2'
        },
        buttonsStyling: false,
    })
    swalWithBootstrapButtons.fire({
        title: 'Estás seguro?',
        text: "Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'me-2',
        confirmButtonText: 'Si, eliminalo!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
    if (result.value) {
        let eliminar = axios.post('/stevlab/recepcion/remove-edit-img-folio', {
            img: perfil,
            folio: identificador,
        }).then(function(response){
            $(obj).parent().parent().remove();
        }).catch(function(error){
            console.log(error);
        });
        swalWithBootstrapButtons.fire(
            'Eliminado!',
            'Imagenologia eliminado de la solicitud.',
            'success'
        )
        } else if (
          // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
        ) {
        swalWithBootstrapButtons.fire(
            'Cancelado',
            'Imagenologia no removido.',
            'error'
            )  
        }
    });
    // $(obj).parent().parent().remove();
    valuarTotal();
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


function verifica_estudios(id){
    axios.post('/stevlab/recepcion/recover-estudios-edit', {
        identificador: id,
    }).then(function(response){
        console.log(response);
        let listas = response.data.data;
        let empresa = $('#id_empresa').val();

        if(response.data.success === true){
            listas.forEach(element => {
                let tabulacion = tab_estudio(element);
                $('#listEstudios').append(tabulacion);
            });
        }
        valuarTotal();
        
    }).catch(function(error){
        console.log(error);
    });
}

function tab_estudio(element){
   
    
    let componente = `  <tr>
                            <th>${element.clave}</th>
                            <td >${element.descripcion}</td>
                            <td>${element.tipo}</td>
                            <td>
                                <span>
                                ${element.precio}
                                </span>
                            </td>
                            <td class='text-center'>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1"></label>
                                </div>
                            </td>
                            <td>
                                <a onclick="removeThisOfficialEstudio(this)"><i class="mdi mdi-backspace"></i></a>
                            </td>
                        </tr>`;
    return componente;
}

function tab_perfiles(element, empresa){
    let perfil = element.id;
    let precio = axios.post('/stevlab/recepcion/check-precio-perfil-edit', {
        perfil: perfil,
        empresa: empresa,
    }).then(function(response){
        precio_final = response.data.precio;
        console.log(response);
    }).catch(function(error){
        console.log(error);
    });

    if(precio_final){
        precio_final = response.data.precio
    }else{
        precio_final = element.precio;
    }

    let list =` <tr>
                    <th>${element.clave}</th>
                    <td >${element.descripcion}</td>
                    <td>Perfiles</td>
                    <td>
                        <span>
                        ${precio_final}
                        </span>
                    </td>
                    <td class='text-center'>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1"></label>
                        </div>
                    </td>
                    <td>
                        <a  onclick="removeThisOfficialPerfil(this)"><i class="mdi mdi-backspace"></i></a>
                    </td>
                </tr>`;
    return list;
}