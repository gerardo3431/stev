<div class="header separador-bottom" style="width: 100%">
    {{-- Data del folio y paciente --}}
    <table >
        <tbody>
            <tr>
                <td>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="col-left"  style="border-bottom: none; ">
                    <strong>Nombre: </strong>{{$paciente->nombre}} {{$paciente->ap_paterno}} {{$paciente->ap_materno}}
                    <br>
                    <strong>Edad:</strong> {{$edad}}
                    <br>
                    <strong>Fecha de nacimiento:</strong> {{$paciente->fecha_nacimiento}}
                    <br>
                    <strong>Telefono:</strong> {{$paciente->celular}}
                </td>
                <td class="col-center"  style="border-bottom: none; " style="white-space: wrap">
                    <strong>Flebotomia: </strong>{{$folios->f_flebotomia}} - {{$folios->h_flebotomia}}
                    <br>
                    <strong>Sexo: </strong>{{strtoupper($paciente->sexo)}}
                    <br>
                    <strong>Doctor que solicita:</strong> {{$doctor->nombre}} {{$doctor->ap_paterno}} {{$doctor->ap_materno}}
                    <br>
                    <strong>Usuario:</strong> {{auth()->user()->sucursal()->where('estatus', 'activa')->first()->sucursal}}
                </td>
                <td class="col-right"  style="border-bottom: none;  text-align: right;">
                    {{-- <strong>Fecha: </strong>  --}}
                    {{-- {{date('m-d-Y h:i:s a', time()) }} --}}
                    <strong>Fecha de pago:</strong> {{$pago->created_at}} 
                    <br>
                    {{-- <strong>Turno: </strong> {{$folios->turno}}
                    <br> --}}
                    <strong>Token de acceso: </strong> {{$folios->token}}
                    <br>
                    {{-- <strong>Folio: </strong> {{ $folios->folio }} --}}
                        @php
                            echo '<img src="data:image/svg+xml;base64,'.base64_encode($barcode).'" />';
                        @endphp
                </td>
            </tr>
            
        </tbody>
    </table>
</div>

