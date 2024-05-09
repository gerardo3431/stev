<div class="footer">
    <table style="line-height: 0.5; font-size:9px">
        <tr >
            <td class="col-left" style="border-bottom: none; line-height: 0.5;">
                <p>
                    <strong>Fecha de impresión: </strong> 
                    {{Date("Y-m-d h:i:s") }}
                </p>
                @include('layout.partials.resultados.indicadores')
            </td>
            <td class="col-center" style="border-bottom: none; line-height: 0.5;">
                <p>
                    @php
                        $pregunta = ($fondo != null) ? $fondo : 'si';
                    @endphp
                    @if ($pregunta == 'no')
                    @else
                        @php
                            echo '<img src="data:image/png;base64, '. $img_valido .'" alt="" height="60" >';
                        @endphp
                    @endif
                    {{-- Kuxtal y palomera si llevan la firma mostrada aunque no tenga fondo --}}
                </p>
                <p> 
                    {{-- {{$folios->valida()->first()->name}} --}}
                    {{($laboratorio->responsable_img) ? $laboratorio->responsable_img : ''}}

                </p>
                <p>
                    Ced. Prof. {{($laboratorio->cedula_img) ? $laboratorio->cedula_img : ''}}
                    {{-- Ced. Prof. {{$folios->valida()->first()->cedula}} --}}
                </p>
                <p>
                    Responsable sanitario
                </p> 
            </td>
            <td class="col-right" style="border-bottom: none; line-height: 0.5; text-align: center">
                <p class="page">Page </p>

            </td>
        </tr>
        
    </table>
    <br>
    <br>
</div>