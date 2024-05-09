<?php use Carbon\Carbon; use App\Models\Analito; ?>

@if ($resultados !== null)
    @php
        $totalAreas = count($resultados);
        $contadorArea = 1;
    @endphp
    @forelse ($resultados as $keyArea => $estudios)
        <div class="invoice-content">
            <h2> >{{$keyArea}}</h2>
            @foreach ($estudios as $keyEstudio => $estudio)
                @if ($estudio->completo === true)
                    <div style="line-height: 0.5;">
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
                            @forelse ($estudio->analitos as $keyAnalito => $analito)
                                {{-- @php
                                    $countrs = 0;
                                @endphp --}}
                                @if ($analito->resultado_esperado)
                                    {{-- @php
                                        $countrs++;
                                    @endphp --}}
                                    @if ($analito->tipo_resultado === 'documento' || $analito->tipo_resultado === 'imagen' || $analito->tipo_resultado === 'subtitulo')
                                        <tr>
                                            <td colspan="6" style="white-space: wrap">
                                                @if ($analito->tipo_resultado === 'documento')
                                                    <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->resultado_esperado ."</span>";?>
                                                @elseif($analito->tipo_resultado === 'imagen')
                                                    @include('layout.partials.resultados.indicadores.analito_imagen')
                                                @elseif($analito->tipo_resultado == 'subtitulo')
                                                    <h4>
                                                        {!! htmlentities($analito->valor_referencia, ENT_NOQUOTES) !!}
                                                    </h4>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="col-one" style="white-space: wrap">
                                                {{$analito->descripcion}}
                                            </td>
                                            <td class="col-two">
                                                @if ($analito->tipo_resultado === 'numerico')
                                                    @php
                                                        $num1   = $analito->numero_uno;
                                                        $num2   = $analito->numero_dos;
                                                        $valor  = $analito->resultado_esperado;
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
                                            <td class="col-three" style="white-space: wrap">
                                            
                                                    @if ($analito->tipo_resultado === 'numerico')
                                                        @if ($valor < $num1 || $valor > $num2)
                                                            <strong style="color:crimson">
                                                        @else
                                                            <strong>
                                                        @endif
                                                        {{$analito->resultado_esperado}}
                                                    @else
                                                            <strong>
                                                    @endif
                                                    
                                                    @if($analito->tipo_resultado === 'texto' || $analito->tipo_resultado === 'referencia')
                                                        {!! htmlentities($analito->resultado_esperado, ENT_NOQUOTES) !!}
                                                    @endif

                                                </strong>
                                            </td>
                                            <td class="col-four">
                                                @if ($analito->resultado_abs !== null)
                                                    {{$analito->resultado_abs}}
                                                @endif
                                            </td>
                                            <td class="col-five">
                                                {{$analito->unidad}}
                                            </td>
                                            <td class="col-six">
                                                @if ($analito->tipo_resultado === 'texto')
                                                    <?php echo $analito->valor_referencia; ?>
                                                @endif
                                                @if ($analito->tipo_resultado === 'numerico')
                                                    {{$analito->numero_uno}} - {{$analito->numero_dos}}
                                                @endif
                                                @if ($analito->tipo_resultado === 'referencia')
                                                    {{$analito->referencias}}
                                                @endif
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
                        {{-- @forelse ($estudio->analitos as $keyAnalito => $analito)
                            @if ($analito->tipo_resultado === 'documento' && $analito->resultado_esperado)
                                <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->resultado_esperado ."</span>";?>
                            @endif

                            @php
                                if($analito->tipo_resultado === 'imagen'  && $analito->resultado_esperado){
                                    $data = base64_encode(Storage::disk('public')->get($analito->resultado_esperado));
                                    echo '<img src="data:image/png;base64,' . $data . ' " alt="" height="200" width="200">';
                                }
                            @endphp
                        @empty
                        @endforelse --}}
                    <br>
                    @include('layout.partials.resultados.indicadores.observaciones')
                    {{-- @if ($countrs < 26)
                        <div class="break"></div>
                    @endif --}}
                @endif
            @endforeach
            @if ($contadorArea !== $totalAreas)
                <div class="break"></div>
            @endif
            @php
                $contadorArea++;
            @endphp
        </div>
    @empty
    @endforelse
@endif
@if ($resultados !== null && $perfiles !== null)
    <div class="break"></div>
@endif
@if($perfiles !== null)
    @forelse ($perfiles as $keyPerfil => $perfil)
        <div class="invoice-content">
            <h1>{{$perfil->descripcion}}</h1>
            @php
                $totalAreas = count($perfil->estudios);
                $contadorArea = 1;
            @endphp
            @foreach ($perfil->estudios as $keyArea => $estudio)
                <h2> >{{$keyArea}}</h2>
                @foreach ($estudio as $keyEstudio => $estudio)
                    @if ($estudio->completo === true)
                        <br>
                        <div style="line-height: 0.5;">
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
                                @forelse ($estudio->analitos as $keyAnalito => $analito)
                                    {{-- @php
                                        $countrs = 0;
                                    @endphp --}}
                                    @if ($analito->resultado_esperado)
                                        {{-- @php
                                            $countrs++;
                                        @endphp --}}
                                        @if ($analito->tipo_resultado === 'documento' || $analito->tipo_resultado === 'imagen' || $analito->tipo_resultado === 'subtitulo')
                                            <tr>
                                                <td colspan="6" style="white-space: wrap">
                                                    @if ($analito->tipo_resultado === 'documento')
                                                    @elseif($analito->tipo_resultado === 'imagen')
                                                        {{-- @include('layout.partials.resultados.indicadores.analito_imagen') --}}
                                                    @elseif($analito->tipo_resultado === 'subtitulo')
                                                        <h4>
                                                            {!! htmlentities($analito->valor_referencia, ENT_NOQUOTES) !!}
                                                        </h4>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="col-one" style="white-space: wrap">
                                                    {{$analito->descripcion}}
                                                </td>
                                                <td class="col-two">
                                                    @if ($analito->tipo_resultado === 'numerico')
                                                        @php
                                                            $num1   = $analito->numero_uno;
                                                            $num2   = $analito->numero_dos;
                                                            $valor  = $analito->resultado_esperado;
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
                                                <td class="col-three" style="white-space: wrap">
                                                    @if ($analito->tipo_resultado === 'numerico')
                                                        @if ($valor < $num1 || $valor > $num2)
                                                            <strong style="color:crimson">
                                                        @else
                                                            <strong>
                                                        @endif
                                                        {{$analito->resultado_esperado}}
                                                    @else
                                                            <strong>
                                                    @endif
                                                        
                                                        @if($analito->tipo_resultado === 'texto' || $analito->tipo_resultado === 'referencia')
                                                            {!! htmlentities($analito->resultado_esperado, ENT_NOQUOTES) !!}
                                                        @endif
                                                    </strong>
                                                </td>
                                                <td class="col-four">
                                                    @if ($analito->resultado_abs !== null)
                                                        {{$analito->resultado_abs}}
                                                    @endif
                                                </td>
                                                <td class="col-five">
                                                    {{$analito->unidad}}
                                                </td>
                                                <td class="col-six">
                                                    @if ($analito->tipo_resultado === 'texto')
                                                        <?php echo $analito->valor_referencia; ?>
                                                    @endif
                                                    @if ($analito->tipo_resultado === 'numerico')
                                                        {{$analito->numero_uno}} - {{$analito->numero_dos}}
                                                    @endif
                                                    @if ($analito->tipo_resultado === 'referencia')
                                                        {{$analito->referencias}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($analito->qr)
                                            <img src="data:image/png;base64,{{$analito->qr}}" alt="" height="100" width="100">
                                        @endif
                                    @else
                                    @endif
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                            @forelse ($estudio->analitos as $keyAnalito => $analito)
                                @if ($analito->tipo_resultado === 'documento' && $analito->resultado_esperado)
                                    <?php echo "<span style='line-height: 0.6; font-size: 10px;'>". $analito->resultado_esperado ."</span>";?>
                                @endif

                                @php
                                    if($analito->tipo_resultado === 'imagen'  && $analito->resultado_esperado){
                                        $data = base64_encode(Storage::disk('public')->get($analito->resultado_esperado));
                                        echo '<img src="data:image/png;base64,' . $data . ' " alt="" height="200" width="200">';
                                    }
                                @endphp
                            @empty
                            @endforelse
                        <br>
                        @include('layout.partials.resultados.indicadores.observaciones')
                        {{-- @if ($countrs < 26)
                            <div class="break"></div>
                        @endif --}}
                    @endif
                @endforeach
                @if ($contadorArea !== $totalAreas)
                    <div class="break"></div>
                @endif
                @php
                    $contadorArea++;
                @endphp
            @endforeach
        </div>
    @empty
        
    @endforelse
@else
@endif

