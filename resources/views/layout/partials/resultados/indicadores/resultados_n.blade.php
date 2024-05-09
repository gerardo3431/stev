@switch($analito->tipo_resultado)
    @case('numerico')
        @if ($analito->valor_captura < $analito->numero_uno || $analito->valor_captura > $analito->numero_dos)
            <strong style="color:crimson">
                {{$analito->valor_captura}}
            <strong>
        @else
            <strong>
                {{$analito->valor_captura}}
            <strong>
        @endif
        @break
    
    @case('referencia')
        @php
            $referencia = $analito->referencia;
        @endphp
        @if ($referencia !== null)
            @if ($analito->valor_captura < $referencia->referencia_inicial || $analito->valor_captura > $referencia->referencia_final)
                <strong style="color:crimson">
                    {{$analito->valor_captura}}
                <strong>
            @else
                <strong>
                    {{$analito->valor_captura}}
                <strong>
            @endif
        @endif
        
        @break
    
    @case('texto')
        <strong>
            {!! htmlentities($analito->valor_captura, ENT_NOQUOTES) !!}
        </strong>
        @break

    
    @default
    
@endswitch