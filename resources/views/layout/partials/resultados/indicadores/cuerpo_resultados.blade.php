@foreach ($estudios as $keyEstudio => $estudio)
    {{-- @dd(count($estudios)) --}}
    {{-- @if (count($estudios[$keyEstudio]->analitos) > 25)
        <div class="break"></div>
    @endif --}}
    <div style="line-height: 0.5;">
        {{-- <h3 style="text-align: center">{{$estudio->descripcion}}</h3> --}}
    </div>
    <table class="result" style='{{$salto === "si" ? "page-break-inside: avoid;" : ""}}'>
        <thead>
            <tr><th colspan="6"><h3 style="text-align: center">{{$estudio->descripcion}}</h3></th></tr>
            <tr>
                <th class="col-one">Nombre</th>
                <th class="col-two"></th>
                <th class="col-three">Resultado</th>
                <th class="col-four"> % </th>
                <th class="col-five">Unidad</th>
                <th class="col-six">Referencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($estudio->analitos as $keyAnalito => $analito)
                @if ($analito->valor_captura !== null)
                    @if ($analito->tipo_resultado === 'subtitulo' || $analito->tipo_resultado === 'imagen' || $analito->tipo_resultado === 'documento')
                        @include('layout.partials.resultados.indicadores.resultados_s')
                    @else
                        <tr>
                            <td class="col-one" >
                                {{$analito->descripcion}}
                            </td>
                            <td class="col-two">
                                @if ($analito->tipo_resultado === 'numerico' || $analito->tipo_resultado === 'referencia')
                                    @include('layout.partials.resultados.indicadores.indicadores')
                                @endif
                            </td>
                            <td class="col-three">
                                @include('layout.partials.resultados.indicadores.resultados_n')
                            </td>
                            <td class="col-four">
                                @if ($analito->valor_captura_abs !== null)
                                    {{$analito->valor_captura_abs}}
                                @endif
                            </td>
                            <td class="col-five">
                                {{ $analito->unidad }}
                            </td>
                            <td class="col-six">
                                @include('layout.partials.resultados.indicadores.valor_ejemplo')
                            </td>
                        </tr>
                    @endif
                    @if ($analito->qr)
                        <img src="data:image/png;base64,{{$analito->qr}}" alt="" height="100" width="100">
                    @endif
                    
                @endif

            @empty
            @endforelse
            
        </tbody>
    </table>
    @include('layout.partials.resultados.indicadores.observaciones')
    {{-- <br> --}}

@endforeach

@include('layout.partials.resultados.indicadores.page_break')