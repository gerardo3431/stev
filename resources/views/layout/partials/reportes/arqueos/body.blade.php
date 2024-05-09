@php
    $total = 0;
    $descuentos = 0;
    $solicitudes = 0;
@endphp
<div class="invoice-content">
    <table >
        <thead>
            <tr>
                <th>FOLIO</th>
                <th>PACIENTE</th>
                <th>MEDICO</th>
                <th>EMPRESA</th>
                <th>MONTO</th>
                <th>ANTICIPO</th>
                <th>ADEUDO</th>
                <th>DESCUENTO</th>
                <th>FECHA</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($folios as $key=> $folio)
                <tr>
                    <td class="border-none">
                        {{$folio->folio}}
                    </td>
                    <td class="border-none">
                        {{$folio->paciente}}
                        
                    </td>
                    <td class="border-none">
                        {{$folio->doctor}}
                    </td>
                    <td class="border-none">
                        {{$folio->empresa}}
                    </td>
                    {{-- Monto --}}
                    <td class="border-none">
                        $ {{$folio->total}}
                    </td>
                    {{-- Anticipo --}}
                    <td class="border-none">
                        $ {{$folio->anticipo}}
                    </td class="border-none">
                    {{-- Adeudos --}}
                    <td class="border-none">
                        $ {{$folio->estado}}
                    </td>
                    <td class="border-none">$ {{ $folio->descuento}}</td>
                    @php
                        $descuentos += $folio->descuento;
                    @endphp
                    <td class="border-none">{{$folio->fecha}}</td>
                </tr>
                <tr>
                    <td  colspan="9">
                        <strong>Estudios: </strong>
                        <span>
                            @forelse ($folio->estudios as $estudio)
                                * {{$estudio}} 
                            @empty
                            @endforelse
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>
        <strong>Total: </strong> $ {{$total}} <br>
        <strong>Descuentos: </strong> $ {{$descuentos}} <br>
        <strong>Total real: </strong> $ {{$total - $descuentos}} <br>
        <strong>Solicitudes: </strong> {{$folios->count()}}
    </p>

</div>