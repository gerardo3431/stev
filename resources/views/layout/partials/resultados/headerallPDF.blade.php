<div class="header separador-bottom">
    
    {{-- Data del laboratorio o empresa --}}
    <table>
        <tbody>
            <tr>
                <td  style="border-bottom: none">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            
        </tbody>
    </table>
    {{-- Data del folio y paciente --}}
    <table>
        <tr>
            <td class="col-left"  style="border-bottom: none; font-size:12px">
                <strong>Nombre: </strong>{{$folios->paciente()->first()->nombre}}
                <br>
                {{-- <strong>Fecha de nacimiento:</strong> {{$paciente->fecha_nacimiento}}
                <br> --}}
                <strong>Edad:</strong> {{$folios->paciente()->first()->specificAge()}} 
                <br>
                <strong>Folio: </strong>{{$folios->folio}}
            </td>
            <td class="col-center"  style="border-bottom: none" style="white-space: wrap">
                <strong>Fecha y hora: </strong>{{$folios->f_flebotomia}} - {{$folios->h_flebotomia}}
                <br>
                <strong>Sexo: </strong>{{strtoupper($folios->paciente()->first()->sexo)}}
                <br>
                <strong>Doctor que solicita:</strong> {{$folios->doctores()->first()->nombre}} {{$folios->doctores()->first()->ap_paterno}} {{$folios->doctores()->first()->ap_materno}}
                {{-- <br>
                <strong>Usuario:</strong> {{$usuario->name}} --}}
            </td>
            <td class="col-right"  style="border-bottom: none">
                <strong>Validacion: </strong> {{$folios->updated_at}}
                <br>
                <strong>Turno: </strong> {{$folios->turno}}
                <br>
                @php
                    echo '<img src="data:image/svg+xml;base64,'.base64_encode($barcode).'" />';
                @endphp
            </td>
        </tr>
    </table>
</div>

