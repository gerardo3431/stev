
@if ($analito->tipo_resultado === 'numerico')
    @php
        $num1   = $analito->numero_uno;
        $num2   = $analito->numero_dos;
        $valor  = $analito->valor_captura;
    @endphp
    
@elseif ($analito->tipo_resultado === 'referencia')
    @php
        $referencia = $analito->referencia ?? null;
        $num1   = isset($referencia->referencia_inicial)? $referencia->referencia_inicial : "No especificado";
        $num2   = isset($referencia->referencia_final)? $referencia->referencia_final : "No especificado";
        $valor  = $analito->valor_captura;
    @endphp
@endif


@if ($valor < $num1 )
    @include('layout.partials.resultados.indicadores.down')
@elseif($valor > $num2)
    @include('layout.partials.resultados.indicadores.up')
@else
    @include('layout.partials.resultados.indicadores.check')
@endif