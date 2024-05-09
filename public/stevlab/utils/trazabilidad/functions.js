'use strict';
// Consulta tablas
$('.consultaFechas').on('change', function(){
    var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
    
    let fecha_inicio    = $('#selectInicio').val();
    let fecha_final     = $('#selectFinal').val();
    let usuario         = $('#selectUsuario').val();
    
    let data = new FormData();
    
    data.append('fecha_inicio', fecha_inicio);
    data.append('fecha_final', fecha_final);
    data.append('usuario', usuario);
    
    setTimeout(() => {
        const response = axios.get('/stevlab/utils/consulta-trazabilidad',{
            params: {
                usuario: usuario,
                fecha_inicio: fecha_inicio,
                fecha_final: fecha_final,
            }
        }).then(res => {
            let dato = res.data;
            console.log(res);
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

$('#dataTableTrazabilidad').on( 'click', 'tr' ,function () {
    let folio = '';
    $(this).find('td:eq(4)').each(function(){
        folio = $(this).html();
    });

    const pregunta = axios.get('/stevlab/utils/query-comments', {
        params:{
            _token: $('meta[name="_token"]').attr('content'),
            folio: folio
        }
    }).then((response)=>{
        let comentario = response.data.data;

        console.log(response);
        $('#modal-comentarios').modal('show');
        $('#bloqueComentarios').empty();
        comentario.forEach(element => {
            $('#bloqueComentarios').append(`<li><strong>Fecha: </strong> ${element.created_at} <br> <strong>Comentario: </strong> ${element.observacion}</li>`);
            
        });
    }).catch((err)=>{
        console.log(err);
    });
});


var BindDataTable = function(response){
    $('#dataTableTrazabilidad').DataTable().destroy();
    var table = $('#dataTableTrazabilidad').DataTable({
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
            {data: null, render: function(data) {
                switch(data.action) {
                    case 'store':
                        return 'Se ha guardado';
                    case 'update':
                        return 'Se ha actualizado';
                    case 'delete':
                        return 'Se ha eliminado';
                    default:
                        return data.action;
                }
            }},
            {data: 'srce_model'},
            {data: null, render: function(data){
                if(data.clave){
                    return data.clave;
                }else if(data.folio != null){
                        return data.folio;
                }else{
                    return data.srce_id;
                }
            }},
            {data: 'trgt_model'},
            {data: null, render: function(data){
                if(data.trgt_model == 'Folios'){
                    return data.folio;
                }else{
                    return data.trgt_id;
                }
            }},
            {data: null, render: function(data){
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
    });
}