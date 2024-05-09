<?php
// $firma  = base64_encode(Storage::disk('public')->get($idFolio->valida()->first()->firma));
?>
<div class="footer">
    <table style="line-height: 0.5; font-size:9px">
        <tr >
            <td class="col-left" style="border-bottom: none; line-height: 0.5;">
                <p>
                    <strong>Fecha de impresión: </strong> 
                    {{Date("Y-m-d h:i:s") }}
                </p>
                @include('layout.partials.resultados.indicadores')
                {{-- <p>
                    El diágnostico e interpretación del resultado queda bajo responsabilidad del médico tratante
                </p> --}}
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
                    {{-- {{($folios->valida()->first()) ? $folios->valida()->first()->name : ''}} --}}
                    {{($laboratorio->responsable_sanitario) ? $laboratorio->responsable_sanitario : ''}}

                </p>
                <p>
                    {{-- Ced. Prof. {{($folios->valida()->first()) ? $folios->valida()->first()->cedula : ''}} --}}
                    Ced. Prof. {{($laboratorio->cedula_sanitario) ? $laboratorio->cedula_sanitario : ''}}
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