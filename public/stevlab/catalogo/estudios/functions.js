'use strict';
function getEstudios(){
    $.ajax({
        url: '/stevlab/catalogo/getOnlyEstudios',
        type: 'GET',
        success: function(response) {
            console.log(response);
            BindDataTable(response);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
            icon: 'success',
            title: 'Actualizando tabla'
            });
        },
        error: function (error){
            console.log(error);
        }           
    });
}

function verEstudio(obj){
    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();
    $('#modal-ver-estudio').modal('show');

    const pregunta = axios.post('/stevlab/catalogo/get-estudio-clave', {
        clave: clave, 
    }).then(function(response){
        // let estudios = response.data;
        remote_ajax(response, 'ver');

    }).catch(function(error){
        console.log(error);
    });
}

    
function editarEstudio(obj){
    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();
    
    $('#modal-editar-estudio').modal('show');

    validar_formulario();

    const pregunta = axios.post('/stevlab/catalogo/get-estudio-clave', {
        clave: clave, 
    }).then(function(response){
        remote_ajax(response, 'editar');
    }).catch(function(error){
        console.log(error);
    });

}
function eliminarEstudio(obj){
    let clave = $(obj).parents('tr').find('td:eq(0)').text().trim();

    const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger me-2'
        },
        buttonsStyling: false,
    });
    
    swalWithBootstrapButtons.fire({
        title: '¿Estas seguro?',
        text: "Esta acción puede causar que algunos estudios desaparezcan del sistema en general, pero esto no elimina las copias existentes en lista de precios.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'me-2',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
    if (result.value) {
        const pregunta = axios.post('/stevlab/catalogo/delete-estudio-clave', {
            clave: clave, 
        }).then(function(response){
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

    
            Toast.fire({
                icon: 'success',
                title: response.data.msj,
            });
            getEstudios();
            
        }).catch(function(error){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    icon: 'Error',
                    title: error.response.data.msj ,
                });
            console.log(error);
        });
        // $('#modalReferencia').modal('hide');
        // window.location.reload();
    } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
        'Cancelado',
        // '',
        'error'
        );
    }
    });

    
}


function validar_formulario(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $("#edit_registro_estudios").validate({
        rules: {
            clave: {
                required: true,
                minlength: 3,
                alphanumeric: true,
                // remote:{
                //     url: "/catalogo/verifyKeyEstudio",
                //     type: 'post',
                //     data:{
                //         _token:CSRF_TOKEN,
                //     }
                // }
            },
            descripcion: {
                required: true,
            },
            
        },
        messages: {
            clave:{
                required: "Por favor ingrese clave.",
                minlength: "Ingrese minimo 3 caracteres.",
                remote: "Clave ya utilizada por otro estudio, por favor ingrese otra clave."
            },
            descripcion:{
                required: "Por favor ingrese descripción."
            }
        },
        errorPlacement: function(error, element) {
            error.addClass( "invalid-feedback" );
            
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            }
        },
        unhighlight: function(element, errorClass) {
            if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            }
        },
        submitHandler: function(){
            update_ajax_estudio();
        }
    });
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[\w.]+$/i.test(value);
    }, "Solo letras y números admitidos.");
}


function identificador_estudio(){
    var identificador = $('#identificador').val();
    
    return identificador;
}

function update_ajax_estudio(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');

    $.ajax({
        url: '/stevlab/catalogo/update-estudio',
        type: 'POST',
        // beforeSend: function(){
        // },
        data: {
            _token: CSRF_TOKEN,
            identificador: identificador_estudio(),
            data: $('#edit_registro_estudios').serializeArray(),
        },
        success: function(response) {
            console.log(response);
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
                title: 'Registro guardado'
                });
                getEstudios();

                // // Reload
                setTimeout(function(){
                    window.location.reload();
                }, 2900);
            // signupForm
        }            
    });
}



var BindDataTable = function(response){
    $('#dataTableEstudios').DataTable().destroy();
    var datatable = $('#dataTableEstudios').DataTable({
        // "order": [ 0, 'desc'],
        responsive: true,
        "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
        ],
        "iDisplayLength": 10,
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
        data: response,
        columns: [
            {data: 'clave'},
            {data: 'descripcion'},
            {data: 'condiciones'},
            { data: null, render: function (data) {
                return `
                    <div class="btn-group" role="group" aria-label="Grupo de botones">
                        <a onclick="verEstudio(this)" class='btn  btn-xs btn-icon btn-primary' ><i class="mdi mdi-eye"></i> </a> 
                        <a onclick="editarEstudio(this)" class="btn btn-xs btn-icon  btn-secondary" ><i class="mdi mdi-pencil"></i> </a> 
                        <a onclick="eliminarEstudio(this)" class="btn btn-xs btn-icon  btn-danger" ><i class="mdi mdi-delete-forever"></i> </a>
                    </div>
                `;
            }},
        ],
        // columnDefs: [
        //     { targets: '_all', render: $.fn.dataTable.render.text(), 
        //         createdCell: function(td, cellData, rowData, row, col) {
        //             if (col < datatable.columns().count() - 1) { // omitir la última columna
        //                 $(td).css('white-space', 'pre-wrap');
        //             }
        //             // $(td).css('white-space', 'pre-wrap');
        //         }
        //     },
        // ],
    });
    $('#dataTableEstudios').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
}