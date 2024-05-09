@if ($resultados != null)
    @php
        $estudios = $folios->estudios()->get();
        foreach ($estudios as $key => $estudio) {
            $areas[$key] = $estudio->areas()->first()->descripcion;
        }
        $areas = array_unique($areas);
        $count = count($areas);
        $i = 0;
    @endphp

    @forelse ($resultados as $key=>$estudio)
        <div class="invoice-content ">
            <div style="line-height: 0.5">
                <h3>{{$estudio->descripcion}}</h3>
            </div>
            <table class="result ">
                <thead>
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
                    
                    @foreach ($estudio->analito as $analito)
                        <tr>
                            @foreach ($estudio->resultado as $resultado)
                                
                                @if($analito->clave == $resultado->clave)
                                    @if($resultado->valor != null)
                                        <td class="col-one">
                                            @if ($analito->tipo_resultado == 'subtitulo')
                                                <h4>{{$analito->valor_referencia}}</h4>
                                            @elseif($analito->tipo_resultado == 'documento')
                                            @else
                                                {{$analito->descripcion}}
                                            @endif
                                        </td>
                                        <td class="col-two">
                                            @if ($analito->tipo_resultado == 'numerico')

                                                @php
                                                    $num1 = $analito->numero_uno;
                                                    $num2 = $analito->numero_dos;
                                                    $valor = $resultado->valor;
                                                @endphp

                                                @if ($valor < $num1)
                                                    @include('layout.partials.resultados.indicadores.down')
                                                @elseif($valor > $num2)
                                                    @include('layout.partials.resultados.indicadores.up')
                                                @else
                                                    @include('layout.partials.resultados.indicadores.check')
                                                @endif

                                            @endif
                                        </td>
                                        <td class="col-three">
                                            @if ($analito->tipo_resultado == 'imagen')
                                            @elseif($analito->tipo_resultado == 'documento')
                                            @elseif($analito->tipo_resultado == 'subtitulo')
                                            @elseif($analito->tipo_resultado == 'numerico')
                                                {{$resultado->valor}}
                                            @else
                                                {!! htmlentities($resultado->valor, ENT_NOQUOTES) !!}
                                            
                                            @endif
                                        </td >
                                        <td class="col-four">
                                            @if ($resultado->valor_abs != null)
                                                {{$resultado->valor_abs}}
                                            @endif
                                        </td>
                                        <td class="col-five">
                                            {{$analito->unidad}}
                                        </td>
                                        <td class="col-six">
                                            @if ($analito->tipo_resultado == 'texto')
                                                <?php echo $analito->valor_referencia ; ?>
                                            @elseif ($analito->tipo_resultado == 'documento')
                                            @elseif ($analito->tipo_resultado == 'imagen')
                                            @elseif ($analito->tipo_resultado == 'numerico')
                                                {{$analito->numero_uno}} - {{$analito->numero_dos}}
                                            @elseif ($analito->tipo_resultado == 'referencia')
                                                {{$analito->referencia}}
                                            @else
                                            @endif
                                        </td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="font-size: 10px;">
                @foreach ($estudio->analito as $analito)
                    @foreach ($estudio->resultado as $resultado)
                        @if($analito->clave == $resultado->clave)
                                @if ($analito->tipo_resultado == 'documento')
                                    <?php echo "<span>". $resultado->valor ."</span>";?>
                                @elseif($analito->tipo_resultado == 'imagen')
                                    @include('layout.partials.resultados.indicadores.analito_imagen')
                                @endif
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div style="font-size: 10px;">
                @if ($estudio->valida_qr == 'on')
                    {{-- @php
                        echo '<img src="data:image/svg+xml;base64,'.base64_encode($qr).'" />';
                    @endphp --}}
                        @php
                            echo '<img src="data:image/svg+xml;base64,'. $estudio->qr .'" />';
                        @endphp
                    @endif

            </div>
            
            @include('layout.partials.resultados.indicadores.observaciones')

            @php
                $i++;
                if($i < $count){
                    echo '<div class="break"></div>';
                }
            @endphp
        </div>
    @empty
    @endforelse
    
@endif
@if($resultados != null && $perfiles != null)
    <div class="break"></div>
@else
@endif
@if ($perfiles != null)
    @forelse ($perfiles as $key=>$perfil)
            <h2>{{$perfil['descripcion']}}</h2>
            @php
                foreach ($perfil['estudios'] as $key => $estudio) {
                    $areas[$key] = $estudio->areas()->first()->descripcion;
                }
                $areas = array_unique($areas);
                // $areas = $folios->areas()->get();
                $count = count($areas);
                $i = 0;
            @endphp
            @foreach ($perfil['estudios'] as $estudio)
            <div class="invoice-content">
                <div style="line-height: 0.5">
                    <h3>{{$estudio->descripcion}}</h3>
                </div>
                <table class="result ">
                    <thead>
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
                        @foreach ($estudio->analito as $analito)
                            <tr>
                                @foreach ($estudio->resultado as $resultado)
                                    
                                    @if($analito->clave == $resultado->clave)
                                        @if($resultado->valor != null)
                                            <td class="col-one">
                                                @if ($analito->tipo_resultado == 'subtitulo')
                                                    <h4>{{$analito->valor_referencia}}</h4>
                                                @elseif($analito->tipo_resultado == 'documento')
                                                @else
                                                    {{$analito->descripcion}}
                                                @endif
                                            </td>
                                            <td class="col-two">
                                                @if ($analito->tipo_resultado == 'numerico')

                                                    @php
                                                        $num1 = $analito->numero_uno;
                                                        $num2 = $analito->numero_dos;
                                                        $valor = $resultado->valor;
                                                    @endphp

                                                    @if ($valor < $num1)
                                                        @include('layout.partials.resultados.indicadores.down')
                                                    @elseif($valor > $num2)
                                                        @include('layout.partials.resultados.indicadores.up')
                                                    @else
                                                        @include('layout.partials.resultados.indicadores.check')
                                                    @endif

                                                @endif
                                            </td>
                                            <td class="col-three">
                                                @if ($analito->tipo_resultado == 'imagen')
                                                @elseif($analito->tipo_resultado == 'documento')
                                                @elseif($analito->tipo_resultado == 'subtitulo')
                                                @elseif($analito->tipo_resultado == 'numerico')
                                                    {{$resultado->valor}}
                                                @else
                                                    {{$resultado->valor}}
                                                @endif
                                            </td >
                                            <td class="col-four">
                                                @if ($resultado->valor_abs != null)
                                                    {{$resultado->valor_abs}}
                                                @endif
                                            </td>
                                            <td class="col-five">
                                                {{$analito->unidad}}
                                            </td>
                                            <td class="col-six">
                                                @if ($analito->tipo_resultado == 'texto')
                                                    <?php echo htmlspecialchars_decode($analito->valor_referencia, ENT_NOQUOTES); ?>
                                                @elseif ($analito->tipo_resultado == 'documento')
                                                @elseif ($analito->tipo_resultado == 'imagen')
                                                @elseif ($analito->tipo_resultado == 'numerico')
                                                    {{$analito->numero_uno}} - {{$analito->numero_dos}}
                                                @elseif ($analito->tipo_resultado == 'referencia')
                                                    {{$analito->referencia}}
                                                @else
                                                @endif
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                <div style="font-size: 10px;">
                    @foreach ($estudio->analito as $analito)
                        @foreach ($estudio->resultado as $resultado)
                            @if($analito->clave == $resultado->clave)
                                    @if ($analito->tipo_resultado == 'documento')
                                    <?php echo "<span>".  $resultado->valor . "</span>"; ?>    
                                    @elseif($analito->tipo_resultado == 'imagen')
                                        @include('layout.partials.resultados.indicadores.analito_imagen')
                                    @endif
                            @endif
                        @endforeach
                    @endforeach
                </div>
                @if ($estudio->valida_qr == 'on')
                    @php
                        echo '<img src="data:image/svg+xml;base64,'. $estudio->qr .'" />';
                    @endphp
                @endif

                @include('layout.partials.resultados.indicadores.observaciones')
                
                @php
                    $i++;
                    if( $i < $count){
                        echo '<div class="break"></div>';
                    }
                @endphp
            </div>
            @endforeach
    @empty
    @endforelse
@endif