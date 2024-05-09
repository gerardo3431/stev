$(function() {
    'use strict';
    $('#dataTableExample').DataTable({
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
        },
        ajax: {
            url: "/stevlab/recepcion/get-folios",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            dataSrc: 'data'
        },
        columns: [
            {data: "folio"},
            {data: null, render: function(data){
                return `<span>${data.paciente[0].nombre ? data.paciente[0].nombre : 'Sin paciente'}</span>`;
            }},
            {data: null, render: function(data){
                return `<span>${data.paciente[0].fecha_nacimiento ? data.paciente[0].fecha_nacimiento : 'Sin paciente'}</span>`;
            }},
            {data: null, render: function(data){
                return `<span>${data.empresas.descripcion ? data.empresas.descripcion : 'Sin empresa'}</span>`;
            }},
            {data: null, render: function(data){
                console.log(data);
                return `
                    <a class="btn btn-xs btn-primary    btn-icon " data-bs-toggle="tooltip" data-bs-placement="top" title="Editar folio" href="recepcion-editar/${data.id}" ><i class="mdi mdi-lead-pencil"></i></a>
                    <a class="btn btn-xs btn-secondary  btn-icon"  data-bs-toggle="tooltip" data-bs-placement="top" title="Reimprimir etiquetas" href="genera-etiqueta?id=${data.id}" target="_blank"><i class="mdi mdi-glass-stange"></i></a>
                    <div class="btn-group ">
                        <button type="button" class="btn btn-xs btn-icon btn-success disabled">
                            <i class="mdi mdi-cash"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-icon btn-success dropdown-toggle dropdown-toggle-split" id="dropdownDown" data-bs-toggle="dropdown" aria-has-popup="true" aria-expanded="false">
                            <span class="visually-hidden">Toggle</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownDown">
                            <a target="_blank" class="dropdown-item" href="/stevlab/recepcion/make-note?folio=${data.id}&tipo=ticket" >Ticket</a>
                            <a target="_blank" class="dropdown-item" href="/stevlab/recepcion/make-note?folio=${data.id}&tipo=hoja" >Hoja</a>
                        </div>
                    </div>
                    <a class="btn btn-xs btn-danger     btn-icon"  data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar folio" href="recepcion-delete-folio/${data.id}" ><i class="mdi mdi-delete"></i></a>
                `;
            }}
        ],
        processing: true,
        serverSide: true,
    });
    $('#dataTableExample').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
});