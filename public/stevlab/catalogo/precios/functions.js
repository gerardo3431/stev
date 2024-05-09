'use strict';
$(function(){
    $('.insertPrecio').hide();

});

function detailList(obj, lista){
    let id = $(obj).parents('tr').find('#claveLista').text();
    let precio = parseFloat($(obj).parents('tr').find('#descuentoLista').text().replace(/[%]/g,''));

    let campo = `
        <input hidden type="number" name="clave_lista" id="clave_lista" value='${id}'>
        <input hidden type="number" name="descuento_lista" id="descuento_lista" value='${precio}'>
                `;
    let data = $(obj).parents('tr').find('#nombreLista').text();

    $('#detailListLabel').empty();
    $('#claveListaNew').empty();

    $('#detailListLabel').append('Precios de estudios/perfiles: ' + data);
    $('#claveListaNew').append(campo);

    $('#detailList').modal('show');
    $('#listPreciosEstudios').empty();
    $('#listPreciosProfiles').empty();
    $('#listPreciosImagenologia').empty();
    

    $('#clave').val(id);
    
    rellenaTablaEstudios($('#clave').val());


    $('#listPreciosEstudios').empty();

}

function editList(obj, lista){
    $('#editList').modal('show');
    $('#list_id').empty();
    $('#list_id').val(lista);
    $('#new_nombre').empty();
}

function guardaLista(){
    // let prueba =  $(this).
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    // let estudios = new FormData();
    let estudios = [];
    
    $('#listPreciosEstudios').find('tr').each(function(){
        estudios.push({
            clave:          $(this).find('td:eq(0)').html(),
            descripcion:    $(this).find('td:eq(1)').html(),
            tipo:           $(this).find('td:eq(2)').html(),
            precio:         $(this).find('td:eq(3)').find(':input').val(),
        });
    });

    $('#listPreciosProfiles').find('tr').each(function(){
        estudios.push({
            clave:          $(this).find('td:eq(0)').html(),
            descripcion:    $(this).find('td:eq(1)').html(),
            tipo:           $(this).find('td:eq(2)').html(),
            precio:         $(this).find('td:eq(3)').find(':input').val(),
        });
    });

    $('#listPreciosImagenologia').find('tr').each(function(){
        estudios.push({
            clave:          $(this).find('td:eq(0)').html(),
            descripcion:    $(this).find('td:eq(1)').html(),
            tipo:           $(this).find('td:eq(2)').html(),
            precio:         $(this).find('td:eq(3)').find(':input').val(),
        });
    });

    $('#saveList').prop('disabled', true);
    $('.search').show();
    // $('#casher').show();
    const prueba = axios.post('/stevlab/catalogo/save-lista', {
        clave: $('#clave').val(),
        estudios : estudios,
    }).then(function(response){
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
        title: 'Lista actualizada correctamente'
        });
        $('#saveList').prop('disabled', false);
        $('.search').hide();

        $('#clave').empty()
        $('#listPreciosProfiles').empty();
        $('#listPreciosEstudios').empty();
        $('#detailList').modal('hide');
    }).catch(function(error){
    });
    
}

function guardaNewNameLista(){
    var nombre = axios.post('/stevlab/catalogo/update-lista-name', {
        ID: $('#list_id').val(),
        nombre: $('#new_nombre').val(),
    }).then(function(response){
        console.log(response);

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        if(response.data){
            Toast.fire({
            icon: 'success',
            title: 'Lista de precio editado correctamente'
            });

            setTimeout(function(){
                window.location.reload();
            }, 3000);

        }

    }).catch(function(err){
        console.log(err);
    });
}

function removeEstudio(obj){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    let clave    = $(obj).parent().parent().find('td:eq(0)').text();

    let data = new FormData();
    data.append('_token', CSRF_TOKEN);
    data.append('clave', clave);
    data.append('precio', $('#clave').val() );


    $.ajax({
        url: '/stevlab/catalogo/elimina-estudio-lista',
        type: 'post',
        data: data,
        contentType: false,
        processData: false,
        success: function(response) {
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
            title: 'Estudio eliminado correctamente'
            });
            
            console.log(response);
            $(obj).parent().parent().remove();
        },
        error: function (jqXHR, textStatus) {
            let responseText = jQuery.parseJSON(jqXHR.responseText);
            console.log(responseText);
        }
    });

}

function doSearch()
        {
            const tableReg = document.getElementById('dataTableEstudios');
            const searchText = document.getElementById('searchTerm').value.toLowerCase();
            let total = 0;
 
            // Recorremos todas las filas con contenido de la tabla
            for (let i = 1; i < tableReg.rows.length; i++) {
                // Si el td tiene la clase "noSearch" no se busca en su cntenido
                if (tableReg.rows[i].classList.contains("noSearch")) {
                    continue;
                }
 
                let found = false;
                const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                // Recorremos todas las celdas
                for (let j = 0; j < cellsOfRow.length && !found; j++) {
                    const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                    // Buscamos el texto en el contenido de la celda
                    if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                        found = true;
                        total++;
                    }
                }
                if (found) {
                    tableReg.rows[i].style.display = '';
                } else {
                    // si no ha encontrado ninguna coincidencia, esconde la
                    // fila de la tabla
                    tableReg.rows[i].style.display = 'none';
                }
            }
 
            // mostramos las coincidencias
            const lastTR=tableReg.rows[tableReg.rows.length-1];
            const td=lastTR.querySelector("td");
            lastTR.classList.remove("hide", "red");
            if (searchText == "") {
                lastTR.classList.add("hide");
            } else if (total) {
                td.innerHTML="Se ha encontrado "+total+" coincidencia"+((total>1)?"s":"");
            } else {
                lastTR.classList.add("red");
                td.innerHTML="No se han encontrado coincidencias";
            }
        }

// $('#listEstudios tr').each(function(){
//     estudios = estudios + parseFloat($(this).find('td:eq(2)').text());
// });

// function showFila(obj){
//     if($(obj).is(':checked')){
//         $(obj).parents('tr').find('td').eq(4).show();
//     }else{
//         $(obj).parents('tr').find('td').eq(4).hide();
//     }
// }

// function saveEstudios(){
//     let lista_estudios = $('#list_estudios').val();
//     let precio = $('#clave_lista').val();

//     const respuesta = axios.post('/stevlab/catalogo/store-precio-estudios', {
//         data: lista_estudios,
//         precio_id: precio
//     })
//     .then(function(response){
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });
        
//         Toast.fire({
//         icon: 'success',
//         title: 'Estudios asignados correctamente'
//         });
//         // Reload
//         setTimeout(function(){
//             window.location.reload();
//         }, 100);
//     })
//     .catch(function(error){
//         console.log(error);
//     });
// }

// function savePerfiles(){
//     let lista_perfiles = $('#list_perfiles').val();
//     let precio = $('#clave_lista').val();

//     const respuesta = axios.post('/stevlab/catalogo/store-precio-profiles', {
//         data: lista_perfiles,
//         precio_id: precio
//     })
//     .then(function(response){
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });
        
//         Toast.fire({
//         icon: 'success',
//         title: 'Perfiles asignados correctamente'
//         });
//         // Reload
//         setTimeout(function(){
//             window.location.reload();
//         }, 100);
//     })
//     .catch(function(error){
//         console.log(error);
//     });
// }

// function removeEstudio(obj){
//     let estudio = $(obj).parents('tr').find('td').eq(0).html();
//     let precio = $('#clave_lista').val();

//     const eliminar = axios.post('/stevlab/catalogo/eliminar-estudios-asignados', {
//         estudio: estudio,
//         precio: precio,
//     }).then(function(response){
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });
        
//         Toast.fire({
//         icon: 'success',
//         title: 'Estudio retirado correctamente'
//         });
//         $(obj).parents('tr').remove();
//         // console.log(response);
//     }).catch(function(error){
//         console.log(error)
//     });
// }

// function removePerfil(obj){
//     let profile = $(obj).parents('tr').find('td').eq(0).html();
//     let precio = $('#clave_lista').val();

//     const eliminar = axios.post('/stevlab/catalogo/eliminar-profiles-asignados', {
//         profile: profile,
//         precio: precio,
//     }).then(function(response){
//         const Toast = Swal.mixin({
//             toast: true,
//             position: 'top-end',
//             showConfirmButton: false,
//             timer: 3000,
//             timerProgressBar: true,
//         });
        
//         Toast.fire({
//         icon: 'success',
//         title: 'Perfil retirado correctamente'
//         });
//         $(obj).parents('tr').remove();
//         // console.log(response);
//     }).catch(function(error){
//         console.log(error)
//     });
// }





