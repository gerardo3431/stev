$(function () {
    "use strict";
    
    $(function () {
        $("#dataTableAnalitos").DataTable({
            // paging: false,
            // info: false,
            // bStateSave: true,
            // sPaginationType: "full_numbers",
            // scrollX: true,
            // scrollY: '70vh',
            // scrollCollapse: true,
            processing: true,
            // serverSide: true,
            // searching: false,
            responsive: true,
            aLengthMenu: [
                [10, 30, 50, -1],
                [10, 30, 50, "All"],
            ],
            iDisplayLength: 10,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
            },
            ajax: {
                url: "/stevlab/catalogo/getAnalitos",
                method: "GET",
                dataSrc: ''
            },
            columns: [
                { data: "clave" },
                { data: "descripcion" },
                { data: "tipo_resultado" },
                { data: null, render: function (data) {
                    if(data.tipo_resultado == 'referencia'){
                        return `<button type='submit' onclick='verAnalito(this)' class='btn btn-xs btn-icon btn-info text-white' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Ver analito'><i class='mdi mdi-eye'></i> </button> <button type='submit' onclick='editarAnalito(this)' class='btn btn-xs btn-icon btn-primary' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Editar analito'><i class='mdi mdi-pencil'></i> </button> <a type='button' class='btn btn-danger btn-xs btn-icon' onclick='eliminaAnalito(this)' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar analito'"><i class='mdi mdi-delete'></i></a> <button type='submit' onclick='editarReferencias(this)' class='btn btn-xs btn-icon btn-secondary' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Editar información anexa'><i class='mdi mdi-human-handsup'></i> </button>`;
                    }else if(data.tipo_resultado == 'imagen'){
                        return `<button type='submit' onclick='verAnalito(this)' class='btn btn-xs btn-icon btn-info text-white' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Ver analito'><i class='mdi mdi-eye'></i> </button> <button type='submit' onclick='editarAnalito(this)' class='btn btn-xs btn-icon btn-primary' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Editar analito'><i class='mdi mdi-pencil'></i> </button> <a type='button' class='btn btn-danger btn-xs btn-icon' onclick='eliminaAnalito(this)' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar analito'"><i class='mdi mdi-delete'></i></a> <button type='submit' onclick='editarImagen(this)' class='btn btn-xs btn-icon btn-secondary'data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Editar información anexa'><i class='mdi mdi-image'></i></a> `;
                    }else{
                        return `<button type='submit' onclick='verAnalito(this)' class='btn btn-xs btn-icon btn-info text-white' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Ver analito'><i class='mdi mdi-eye'></i> </button> <button type='submit' onclick='editarAnalito(this)' class='btn btn-xs btn-icon btn-primary' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Editar analito'><i class='mdi mdi-pencil'></i> </button> <a type='button' class='btn btn-danger btn-xs btn-icon' onclick='eliminaAnalito(this)' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar analito'"><i class='mdi mdi-delete'></i></a>`;
                    }
                }},
            ],
        });
        $("#dataTableAnalitos").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });
    });
});

function eliminaAnalito(obj){
    // console.log($(obj).closest('tr').find('td:eq(0)').text());

    let identificador = $(obj).closest('tr').find('td:eq(0)').text();

    var eliminacion = axios.get('/stevlab/catalogo/deleteAnalito', {
        params:{
            ID: identificador,
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
                title: "Analito eliminado",
            });
            setTimeout(function(){
                window.location.reload();
            }, 3100);
        }else{
            Toast.fire({
                icon: 'info',
                title: "Analito no eliminado",
            });
        }
    }).catch(function(error){
        console.log(error);
    });
}
