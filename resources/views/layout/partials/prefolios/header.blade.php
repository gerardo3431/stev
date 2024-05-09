<div class="header separador-bottom" style="width: 100%">
    {{-- Data del folio y paciente --}}
    <table >
        <tbody>
            <tr>
                <td class="col-left"  style="border-bottom: none; ">
                    <strong>Nombre: </strong> {{$nombre}}
                    <br>
                    <strong>Prefolio: </strong> {{$prefolio->prefolio}}
                </td>
                <td class="col-center"  style="border-bottom: none; ">
                    <strong>Fecha y hora de registro: {{$prefolio->created_at}}</strong>
                    <br>
                    <strong>Doctor que solicita:</strong> {{auth()->user()->name}}
                    <br>
                </td>
                <td class="col-right"  style="border-bottom: none;  text-align: right;">
                    <strong>Fecha de impresión: </strong> 
                    {{Date("d/m/Y") }}
                    <br>
                </td>
            </tr>

        </tbody>
    </table>
</div>

