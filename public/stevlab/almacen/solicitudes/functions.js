'use strict';

$(function(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    $('#ubicacion').on("change", function(){
        const ubicacion = axios.get('/stevlab/almacen/getArticlesList', {
            params:{
                ubicacion : $('#ubicacion').val(),
            }
        }).then(function(success){
            console.log(success);
            // $('#listEstudio').select2('destroy');
            // $('#listEstudio').empty();
            // $('#listEstudio').select2({
            //         placeholder: 'Buscar estudios',
            //         data: lista
            // });
            var nuevosDatos = $.map(success.data, function(item) {
                return { id: item.id, text: item.descripcion };
            });
            $("#listArticles").empty().select2({ data: nuevosDatos }).trigger("change");
            $("#listArticles").select2("destroy").select2({
                placeholder: 'Buscar articulo',
                maximumSelectionLength: 1,
                minimumInputLength: 3,
            });
            $("#listArticles").on('select2:select', function(e) {
                console.log(e.params.data);
                var data = e.params.data;
                // $('#listArticles').append(data.text).trigger('change');
                // checkArticle(data.id);
                axios.get('/stevlab/catalogo/get-article', {
                    params: {
                        _token: CSRF_TOKEN,
                        idArticle: data.id,
                        ubicacion: $('#ubicacion').val(),
                    }
                })
                .then(function (response) {
                    console.log(response);
                    let articulo = response.data;
                    $("#clave").val(articulo.clave);
                    $("#unidad").val(articulo.unidad.toUpperCase());
                    $("#existencia_general").val(articulo.almacen_general);
                    $("#existencia").val(articulo.cantidad);
                    $("#solicitud").val(articulo.surtir)

                    // add_article(response.data, $('#cantidad').val());
                    // renderiza();
                })
                .catch(function (error) {
                console.log(error);
                })
                .finally(function () {
                // always executed
                });  
            });
            $("#listArticles").on('select2:unselect', function (e) {
                // Limpia el campo al deseleccionar un elemento
                $('#listArticles').val(null).trigger('change');
                $('#addSolicitud')[0].reset();
                $("#caducidad").attr('disabled', true);
                $("#lote").attr('disabled', true);
            });


        }).catch(function(error){
            console.log(error);
        }).finally(function(){
        });
    });    

    let arreglo = [];

    $('#addMaterial').on('click', function(event){
        event.preventDefault();

        let cantidad = $('#cantidad').val();

        console.log("clave:", $('#clave').val(), "ubicacion:", $('#ubicacion').val());

        let existe = arreglo.find(ed => ed.clave === $('#clave').val().toString() && ed.area === $('#ubicacion').val().toString());
        // console.log(existe);
        if (existe) {
            existe.cantidad = parseInt(existe.cantidad) + parseInt($('#cantidad').val()); // sumar la cantidad nueva a la existente
        } else{
            if(cantidad != 0 && cantidad != ""){
                arreglo.push({
                    clave : $('#clave').val(),
                    articulo: $('#listArticles').select2('data')[0].text,
                    unidad: $('#unidad').val(),
                    area:$('#ubicacion').val(),
                    cantidad: $('#cantidad').val(),
                    existencias: $('#existencia').val(),
                    pendientes: $('#solicitud').val(),
                }); 
            }else{
                Toast.fire({
                    icon: 'error',
                    title: 'Inserte cantidad correcta antes de agregar articulo',
                });
            }

        }

        $('#tableListArticles').empty();

        // Realiza foreach para insertar el arreglo y no lo que estoy mandando por default
        arreglo.forEach(element => {
            console.log(element);
            let fila = `
                <tr>
                    <td>${element.clave}</td>
                    <td>${element.articulo}</td>
                    <td>${element.unidad}</td>
                    <td></td>
                    <td>${element.area}</td>
                    <td>${element.cantidad}</td>
                    <td>${element.existencias}</td>
                    <td>${element.pendientes}</td>
                    <td></td>
                </tr>
            `;
            $('#tableListArticles').append(fila);
            $('#addSolicitud')[0].reset();
            $('#listArticles').val(null).trigger('change');
        });

        if(cantidad != 0 && cantidad != ""){
            // let fila = `
            //     <tr>
            //         <td>${$('#clave').val()}</td>
            //         <td>${$('#listArticles').select2('data')[0].text}</td>
            //         <td>${$('#unidad').val()}</td>
            //         <td></td>
            //         <td>${$('#ubicacion').val()}</td>
            //         <td>${$('#cantidad').val()}</td>
            //         <td>${$('#existencia').val()}</td>
            //         <td>${$('#solicitud').val()}</td>
            //         <td></td>
            //     </tr>
            // `;
            // $('#tableListArticles').append(fila);
            // $('#addSolicitud')[0].reset();
            // $('#listArticles').val(null).trigger('change');
        }else{
            // Toast.fire({
            //     icon: 'error',
            //     title: 'Inserte cantidad correcta antes de agregar articulo',
            // });
        }


        console.log(arreglo);
    });
    
    return false;

});

function add_article(response){
    response.forEach(element => {
        let fila = `
                    <tr>
                        <td>${element.clave}</td>
                        <td>${element.descripcion}</td>
                        <td>${element.unidad}</td>
                        <td></td>
                        <td>${element.ubicacion}</td>
                        <td>${element.pivot.cantidad}</td>
                        <td>${element.cantidad}</td>
                        <td>${element.surtir}</td>
                        <td></td>
                    </tr>
                `;
        $('#tableListArticles').append(fila);
    });
    // console.log(ubicacion);
}