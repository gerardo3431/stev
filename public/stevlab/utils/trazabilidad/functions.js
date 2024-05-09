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
            {data: 'log_name'},
            {data: 'description'},
            {data: 'subject_type'},
            {data: 'subject_id'},
            {data: 'causer_type'},
            {data: 'causer_id'},
            {data: null, render: function(data){
                console.log(data);
                return data.properties.estudio ?? (data.properties.perfil ?? 'Deshabilitado'); 
            }},
            {data: null, render: function (data){
                return moment(data.created_at).format('DD-MM-YYYY HH:mm:ss')
            }}
        ],
        language:{ 
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },
    });
}