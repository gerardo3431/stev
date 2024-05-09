$(function(){

    $('.row').on('keyup','.evalComision', function(){
        var valor = $(this).val();
        var costo = $(this).closest('tr').find('td:eq(1)').text();
        console.log(costo);

        var porcentaje = costo * (valor / 100);

        $(this).closest('tr').find('.resultEval').empty();
        $(this).closest('tr').find('.resultEval').append(porcentaje);

    });

    $('#addForm').on('click', function(){
        let fecha_inicio =$('#selectInicio').val() ;
        let fecha_final = $('#selectFinal').val();
        let doctores = $('#listDoctors').val();
        let empresas = $('#listEmpresas').val();
        let form = new FormData();

        form.append('fecha_inicio', fecha_inicio);
        form.append('fecha_final', fecha_final);
        form.append('doctores', doctores);
        form.append('empresas', empresas);


        const respuesta = axios.post('/stevlab/reportes/getData', form , {
        }).then(function(response){
            console.log(response);
            // Mando a limpiar y genero el cuerpo de nuevo
            $('#renderDoc').empty();
            let doctores = renderDocemp(response.data.doctores)
            $('#renderDoc').append(doctores);

            $('#renderEmp').empty();
            let empresas = renderDocemp(response.data.empresas)
            $('#renderEmp').append(empresas);

            $('#renderFol').empty();
            let folios = renderFolio(response.data.folios)
            $('#renderFol').append(folios);

        }).catch(function(error){
            console.log(error);
        });

    });
});

function renderDocemp(response){
    let componente = '';
    for(let key in response){
        if (response.hasOwnProperty(key)) {
            let element = response[key];
            let component = `
                <tr>
                    <td>${(element.nombre != null) ? element.nombre : element.descripcion}</td>
                    <td>${element.total}</td>
                    <td>
                        <input type="number" min='0' max='100' class="form-control evalComision">
                    </td>
                    <td>
                        <span class='resultEval'>
                            $00.00
                        </span>
                    </td>
                </tr>
            `;
            componente = componente + component;
        }
    }

    return componente;

}

function renderFolio(response){
    // console.log(response);
    let componente = '';

    for(let key in response){
        if (response.hasOwnProperty(key)) {
            let element = response[key];
            let component = `
                <tr>
                    <td>${element.folio}</td>
                    <td style='white-space: pre-wrap'>${element.paciente}</td>
                    <td style='white-space: pre-wrap'>${element.doctor}</td>
                    <td>${element.empresa}</td>
                    <td>$ ${element.pago}</td>
                    <td>$ ${element.descuento}</td>
                    <td>$ ${(element.num_total - element.pago) - element.descuento}</td>
                    <td>$ ${element.num_total}</td>
                </tr>
            `;
            componente = componente + component;
        }
    }

    return componente;

}